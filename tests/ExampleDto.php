<?php

declare(strict_types=1);

namespace Sd1328\DataObjects\Tests;

use Sd1328\DataObjects\Dto;

/**
 * Class ExampleDto
 *
 * @property $mixed
 * @property int $int
 * @property float $float
 * @property string $string
 * @property bool $bool
 * @property array $array
 * @property \Sd1328\DataObjects\Dto $dto
 * @property null|int $_int
 * @property null|float $_float
 * @property null|string $_string
 * @property null|bool $_bool
 * @property null|array $_array
 * @property null|\Sd1328\DataObjects\Dto $_dto
 */
class ExampleDto extends Dto
{
    protected $mixed;

    protected int $int;

    protected float $float;

    protected string $string;

    protected bool $bool;

    protected array $array;

    protected Dto $dto;


    protected ?int $_int;

    protected ?float $_float;

    protected ?string $_string;

    protected ?bool $_bool;

    protected ?array $_array;

    protected ?Dto $_dto;
}
