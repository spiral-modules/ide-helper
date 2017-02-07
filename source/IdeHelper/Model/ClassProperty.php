<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 * @licence   MIT
 */

namespace Spiral\IdeHelper\Model;

/**
 * Class ClassProperty
 *
 * @package Spiral\IdeHelper\Model
 */
class ClassProperty extends ClassMember
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string[]
     */
    private $types;

    /**
     * ClassProperty constructor.
     *
     * @param string       $name
     * @param string|array $types
     */
    public function __construct(string $name, $types)
    {
        $this->name = $name;
        if (is_string($types)) {
            $this->types = [$types];
        } elseif (is_array($types)) {
            $this->types = $types;
        } else {
            $this->types = [self::DEFAULT_TYPE];
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return \string[]
     */
    public function getTypes(): array
    {
        return $this->types;
    }
}
