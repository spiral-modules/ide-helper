<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 * @licence   MIT
 */

namespace Spiral\IdeHelper\Model;

/**
 * Class ClassDefinition
 *
 * @package Spiral\IdeHelper\Model
 */
class ClassDefinition
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $shortName;

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var ClassMember[]
     */
    private $members;

    /**
     * ClassDefinition constructor.
     *
     * @param string $name
     * @param array  $members
     */
    public function __construct(string $name, array $members)
    {
        $this->name = $name;
        $this->members = $members;

        $this->setNames($name);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getShortName(): string
    {
        return $this->shortName;
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @return ClassMember[]
     */
    public function getMembers(): array
    {
        return $this->members;
    }

    private function setNames(string $name)
    {
        if (class_exists($name) || interface_exists($name)) {
            $reflection = new \ReflectionClass($name);
            $this->shortName = $reflection->getShortName();
            $this->namespace = $reflection->getNamespaceName();
        } else {
            $components = explode('\\', $name);

            $this->shortName = array_pop($components);
            $this->namespace = implode('\\', $components);
        }
    }
}
