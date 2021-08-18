<?php

declare(strict_types=1);

namespace Sd1328\DataObjects\Serializer;

use Generator;
use Sd1328\DataObjects\Dto;
use Sd1328\DataObjects\Exceptions\DtoDomainException;

/**
 * Class Serializer
 * Компонент Сериализации DTO
 */
class Serializer
{
    public const DATA_FIELD = 'data';
    public const CLASS_FIELD = 'class';


    private ?array $expectedFields = null;

    private ?array $ignoreFields = null;

    public function whereIn(array $expectedFields): self
    {
        if ($this->expectedFields === null) {
            $this->expectedFields = [];
        }
        $this->expectedFields = array_merge($this->expectedFields, $expectedFields);
        return $this;
    }

    public function whereNotIn(array $ignoreFields): self
    {
        if ($this->ignoreFields === null) {
            $this->ignoreFields = [];
        }
        $this->ignoreFields = array_merge($this->ignoreFields, $ignoreFields);
        return $this;
    }

    public function toArray(Dto $dto): array
    {
        return [
            self::CLASS_FIELD => get_class($dto),
            self::DATA_FIELD => iterator_to_array($this->pack($dto)),
        ];
    }

    public function toJson(Dto $dto): string
    {
        return json_encode($this->toArray($dto));
    }

    /**
     * @param Dto $dto
     * @return Generator
     */
    private function pack(Dto $dto): Generator
    {
        foreach ($dto->getProperties() as $name => $value) {
            if ($this->ignoreFields !== null && in_array($name, $this->ignoreFields)) {
                continue;
            }
            if ($this->expectedFields !== null && !in_array($name, $this->expectedFields)) {
                continue;
            }
            yield $name => $this->packValue($value);
        }
        $this->ignoreFields = null;
        $this->expectedFields = null;
    }

    /**
     * @param array|bool|float|int|string|null|Dto $value
     * @return array|bool|float|int|string|null
     */
    private function packValue($value)
    {
        if (is_null($value) || is_scalar($value)) {
            return $value;
        }
        if (is_object($value) && $value instanceof Dto) {
            return $this->toArray($value);
        }
        if (is_array($value)) {
            $result = [];
            foreach ($value as $key => $item) {
                $result[$key] = $this->packValue($item);
            }
            return $result;
        }
        throw new DtoDomainException(
            "Failed to serialize DTO value:" . substr(print_r($value, true), 0, 255)
        );
    }
}
