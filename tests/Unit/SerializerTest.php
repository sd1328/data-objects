<?php
namespace Sd1328\DataObjects\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sd1328\DataObjects\Serializer\Deserializer;
use Sd1328\DataObjects\Serializer\Serializer;
use Sd1328\DataObjects\Tests\ExampleDto;

class SerializerTest extends TestCase
{
    public function providerDto(): array
    {
        return [
            [
                'dtoFields' => [
                    'mixed' => 'new stdClass()',
                    'int' => 12,
                    'float' => 1.2,
                    'string' => 'erer',
                    'bool' => true,
                    'array' => [1 => 'one', 10 => 'ten'],
                    'dto' => new ExampleDto([]),
                    '_int' => null,
                    '_float' => null,
                    '_string' => null,
                    '_bool' => null,
                    '_array' => null,
                    '_dto' => null,
                ],
            ],
        ];
    }

    /**
     * @param array $dtoFields
     * @dataProvider providerDto
     */
    public function testDto(array $dtoFields): void
    {
        $expectedDto = new ExampleDto();
        foreach ($dtoFields as $fieldName => $fieldValue) {
            $expectedDto->$fieldName = $fieldValue;
        }
        $serialize = new Serializer();
        $json = $serialize->toJson($expectedDto);

        $deserialize = new Deserializer();
        $actualDto = $deserialize->fromJson($json);

        $this->assertEquals(
            iterator_to_array($expectedDto->getProperties()),
            iterator_to_array($actualDto->getProperties())
        );
    }
}
