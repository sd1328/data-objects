<?php

namespace Sd1328\DataObjects\Serializer;

use Sd1328\DataObjects\Dto;
use Sd1328\DataObjects\Exceptions\DtoDomainException;


class Deserializer
{
    public function fromArray(array $array): Dto
    {
        if (!isset($array[Serializer::CLASS_FIELD])) {
            throw new DtoDomainException("Invalid structure, array cannot be deserialized");
        }
        $class = $array[Serializer::CLASS_FIELD];
        $reflection = new \ReflectionClass($class);
        if (!$reflection->isSubclassOf(Dto::class)) {
            throw new DtoDomainException("The specified class [$class] is not a DTO");
        }

        if (!isset($array[Serializer::DATA_FIELD])) {
            throw new DtoDomainException("Invalid structure, array cannot be deserialized");
        }
        $data = $array[Serializer::DATA_FIELD];

        return new $class($this->deserialize($data));
    }

    protected function deserialize($data): array
    {
        foreach ($data as $name => $value) {
            if (
                is_array($value) &&
                count($value) == 2 &&
                isset($value[Serializer::CLASS_FIELD]) &&
                isset($value[Serializer::DATA_FIELD]))
            {
                $data[$name] = $this->fromArray($value);
            }
        }
        return $data;
    }

    public function fromJson(string $json): Dto
    {
        return $this->fromArray(
            json_decode($json, true)
        );
    }
}
