<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 * @licence   MIT
 */

namespace Spiral\IdeHelper\Locators;

use Psr\Log\LoggerInterface;
use Spiral\IdeHelper\Model\ClassDefinition;
use Spiral\IdeHelper\Model\ClassProperty;
use Spiral\ODM\DocumentEntity;
use Spiral\ODM\Entities\DocumentCompositor;
use Spiral\ODM\ODM;
use Spiral\ODM\Schemas\Definitions\CompositionDefinition;
use Spiral\ODM\Schemas\DocumentSchema;

/**
 * Class DocumentsLocator
 *
 * @package Spiral\IdeHelper\Locators
 */
class DocumentsLocator implements LocatorInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \Spiral\ODM\Schemas\SchemaInterface[]
     */
    private $schemas;

    /**
     * @var \Spiral\ODM\Schemas\SchemaBuilder
     */
    private $builder;

    /**
     * DocumentsLocator constructor.
     *
     * @param LoggerInterface $logger
     * @param ODM             $odm
     */
    public function __construct(LoggerInterface $logger, ODM $odm)
    {
        $this->logger = $logger;

        $this->builder = $odm->schemaBuilder();
        $this->schemas = $this->builder->getSchemas();
    }

    /**
     * @inheritdoc
     */
    public function locate(): array
    {
        $documents = [];

        foreach ($this->schemas as $schema) {
            if ($schema instanceof DocumentSchema) {
                $className = $schema->getClass();
                $members = $this->scan($schema);

                $documents[] = new ClassDefinition($className, $members);
            } else {
                $this->logger->warning("Schema for {$schema->getClass()} is not "
                    . DocumentSchema::class . " instance");
            }
        }

        return $documents;
    }

    /**
     * @param DocumentSchema $schema
     * @return array
     */
    private function scan(DocumentSchema $schema): array
    {
        $fields = $this->processFields($schema->getFields());
        $mutators = $this->processMutators($schema->getMutators());
        $compositions = $this->processCompositions($schema->getCompositions($this->builder));

        $properties = array_merge($fields, $mutators, $compositions);
        $docs = [];
        foreach ($properties as $name => $type) {
            $docs[] = new ClassProperty($name, $type);
        }

        return $docs;
    }

    /**
     * @param array $fields
     * @return array
     */
    private function processFields(array $fields): array
    {
        $results = [];

        foreach ($fields as $name => $definition) {
            if (!is_array($definition)) {
                $class = $definition;
            } else {
                $class = $definition[0] . '[]';
            }

            $results[$name] = $class;
        }

        return $results;
    }

    /**
     * @param array $mutators
     * @return array
     */
    private function processMutators(array $mutators): array
    {
        $results = [];

        foreach ($mutators['accessor'] as $name => $type) {
            $results[$name] = $type;
        }

        return $results;
    }

    /**
     * @param array $compositions
     * @return array
     */
    private function processCompositions(array $compositions): array
    {
        $results = [];

        foreach ($compositions as $name => $definition) {
            if ($definition instanceof CompositionDefinition) {
                switch ($definition->getType()) {
                    case DocumentEntity::ONE:
                        $class = $definition->getClass();
                        break;
                    case DocumentEntity::MANY:
                        $class = $definition->getClass() . '[]';
                        break;
                    default:
                        throw new \RuntimeException('Unknown definition type: '
                            . $definition->getType());
                }

                $types = [DocumentCompositor::class, $class];
                $results[$name] = $types;
            }
        }

        return $results;
    }
}
