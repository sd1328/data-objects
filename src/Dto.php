<?php

declare(strict_types=1);

namespace Sd1328\DataObjects;

use Generator;

abstract class Dto
{
    public const SERVICE_FIELDS = [
        '_isWritable',
    ];

    private bool $_isWritable;

    public function __construct(?array $data = null)
    {
        if ($data === null) {
            $this->_isWritable = true;
            return;
        }
        foreach ($data as $propertyName => $propertyValue) {
            $this->$propertyName = $propertyValue;
        }
        $this->_isWritable = false;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value): void
    {
        if (!$this->_isWritable) {
            throw new \InvalidArgumentException("Свойство [$name] доступно только для чтения");
        }
        if (!property_exists($this, $name)) {
            throw new \InvalidArgumentException("Свойство [$name] не существует");
        }
        $this->$name = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            throw new \InvalidArgumentException("Неизвестное свойство $name");
        }
    }

    public function getProperties(): Generator
    {
        foreach ($this as $name => $value) {
            if (in_array($name, self::SERVICE_FIELDS)) {
                continue;
            }
            yield $name => $value;
        }
    }
}
