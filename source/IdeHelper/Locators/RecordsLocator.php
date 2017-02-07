<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 * @licence   MIT
 */

namespace Spiral\IdeHelper\Locators;

use Psr\Log\LoggerInterface;
use Spiral\Database\Schemas\Prototypes\AbstractColumn;
use Spiral\IdeHelper\Model\ClassDefinition;
use Spiral\IdeHelper\Model\ClassMember;
use Spiral\IdeHelper\Model\ClassProperty;
use Spiral\ORM\Configs\RelationsConfig;
use Spiral\ORM\ORM;
use Spiral\ORM\RecordEntity;
use Spiral\ORM\Schemas\RecordSchema;
use Spiral\ORM\Schemas\RelationInterface;

/**
 * Class RecordsLocator
 *
 * @package Spiral\IdeHelper\Locators
 */
class RecordsLocator implements LocatorInterface
{
    /**
     * @var ORM
     */
    private $orm;

    /**
     * @var RelationsConfig
     */
    private $relationsConfig;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * RecordsLocator constructor.
     *
     * @param ORM             $orm
     * @param RelationsConfig $config
     */
    public function __construct(ORM $orm, RelationsConfig $config)
    {
        $this->orm = $orm;
        $this->relationsConfig = $config;
    }

    /**
     * @inheritDoc
     */
    public function locate(): array
    {
        $builder = $this->orm->schemaBuilder()->renderSchema();
        $schemas = $builder->getSchemas();
        $relations = $builder->getRelations();

        $records = [];
        foreach ($schemas as $schema) {
            if ($schema instanceof RecordSchema) {
                $columns = $builder->requestTable($schema->getTable())->getColumns();
                $members = $this->scan($schema, $columns, $relations);

                $records[] = new ClassDefinition($schema->getClass(), $members);
            } else {
                $this->logger->warning("Schema for {$schema->getClass()} is not "
                    . RecordSchema::class . " instance");
            }
        }

        return $records;
    }

    /**
     * @param RecordSchema        $context
     * @param AbstractColumn[]    $columns
     * @param RelationInterface[] $relations
     *
     * @return ClassMember[]
     */
    private function scan(RecordSchema $context, array $columns, array $relations)
    {
        $cols = $this->processColumns($columns);
        $fields = $this->processFields($context->getFields(), $columns);
        $relations = $this->findRelations($context->getClass(), $relations);

        $properties = array_merge($cols, $fields, $relations);

        $docs = [];
        foreach ($properties as $name => $type) {
            $docs[] = new ClassProperty($name, $type);
        }

        return $docs;
    }

    /**
     * @param AbstractColumn[] $columns
     *
     * @return array
     */
    private function processColumns(array $columns): array
    {
        $results = [];

        foreach ($columns as $column) {
            $types = [$column->phpType()];

            if ($column->isNullable()) {
                $types[] = 'null';
            }

            $results[$column->getName()] = $types;
        }

        return $results;
    }

    /**
     * @param array            $fields
     * @param AbstractColumn[] $columns
     *
     * @return array
     */
    private function processFields(array $fields, array $columns): array
    {
        $results = [];

        foreach (array_keys($fields) as $field) {
            $column = $columns[$field];
            $types = [$column->phpType()];
            if ($column->isNullable()) {
                $types[] = 'null';
            }

            $results[$field] = $types;
        }

        return $results;
    }

    /**
     * @param string              $class
     * @param RelationInterface[] $relations
     *
     * @return array
     */
    private function findRelations(string $class, array $relations): array
    {
        $results = [];

        foreach ($relations as $relation) {
            $definition = $relation->getDefinition();
            if ($definition->sourceContext()->getClass() === $class) {
                $name = $definition->getName();
                $types = [];

                $relationType = $definition->getType();
                if (in_array($relationType, [RecordEntity::MANY_TO_MANY, RecordEntity::HAS_MANY])) {
                    $types[] = $definition->getTarget() . '[]';
                } else {
                    $types[] = $definition->getTarget();
                }

                $types[] = $this->relationsConfig->relationClass($relationType,
                    RelationsConfig::ACCESS_CLASS);

                $options = $definition->getOptions();
                if (array_key_exists(RecordEntity::NULLABLE, $options)
                    && true === $options[RecordEntity::NULLABLE]
                ) {
                    $types[] = 'null';
                }

                $results[$name] = $types;
            }
        }

        return $results;
    }
}
