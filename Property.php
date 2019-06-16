<?php

namespace Mapper;

class Property
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $collection = false;

    /**
     * @var Definition
     */
    private $definition;

    /**
     * @var string
     */
    private $localColumn;

    /**
     * @var string
     */
    private $foreignColumn;

    /**
     * Property constructor.
     *
     * @param string     $name
     * @param bool       $collection
     * @param Definition $definition
     * @param string     $localColumn
     * @param string     $foreignColumn
     */
    public function __construct(string $name, bool $collection, Definition $definition, string $localColumn, string $foreignColumn)
    {
        $this->name = $name;
        $this->collection = $collection;
        $this->definition = $definition;
        $this->localColumn = $localColumn;
        $this->foreignColumn = $foreignColumn;
    }

    /**
     * Returns the property's name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns true if the property is a collection.
     *
     * @return bool
     */
    public function isCollection()
    {
        return $this->collection;
    }

    /**
     * Returns the definition used to fetch the property.
     *
     * @return Definition
     */
    public function getDefinition()
    {
        return $this->definition;
    }

    /**
     * Returns the local column name.
     *
     * @return string
     */
    public function getLocalColumn()
    {
        return $this->localColumn;
    }

    /**
     * Returns the foreign column name.
     *
     * @return string
     */
    public function getForeignColumn()
    {
        return $this->foreignColumn;
    }
}

