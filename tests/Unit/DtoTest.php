<?php

namespace Sd1328\Definition\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sd1328\DataObjects\Tests\ExampleDto;

class DtoTest extends TestCase
{
    public function providerDtoFields(): array
    {
        return [
            ['mixed', 'new stdClass()',],
            ['int',  12,],
            ['float', 1.2,],
            ['string', 'erer',],
            ['bool', true,],
            ['array', [1 => 'one', 10 => 'ten'],],
            ['dto', new ExampleDto(),],
            ['_int', null,],
            ['_float', null,],
            ['_string', null,],
            ['_bool', null,],
            ['_array', null,],
            ['_dto', null,],
        ];
    }

    /**
     * @param string $fieldName
     * @param $value
     * @dataProvider providerDtoFields
     */
    public function testDto(string $fieldName, $value): void
    {
        $dto = new ExampleDto();
        $dto->$fieldName = $value;
        $this->assertEquals($value, $dto->$fieldName);
    }
}
