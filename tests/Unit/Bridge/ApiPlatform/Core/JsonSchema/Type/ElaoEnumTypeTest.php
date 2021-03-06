<?php

/*
 * This file is part of the "elao/enum" package.
 *
 * Copyright (C) Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Enum\Tests\Unit\Bridge\ApiPlatform\Core\JsonSchema\Type;

use ApiPlatform\Core\JsonSchema\TypeFactory;
use Elao\Enum\Bridge\ApiPlatform\Core\JsonSchema\Type\ElaoEnumType;
use Elao\Enum\Tests\Fixtures\Enum\Gender;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PropertyInfo\Type;

/**
 * @requires PHP >= 7.1
 */
class ElaoEnumTypeTest extends TestCase
{
    /**
     * @dataProvider typeProvider
     */
    public function testGetType(array $expected, Type $type): void
    {
        $typeFactory = new ElaoEnumType(new TypeFactory());
        $this->assertEquals($expected, $typeFactory->getType($type, 'json'));
    }

    public function typeProvider(): iterable
    {
        yield [
            [
                'type' => 'string',
                'enum' => [
                    0 => 'unknown',
                    1 => 'male',
                    2 => 'female',
                ],
                'example' => 'unknown',
            ],
            new Type(Type::BUILTIN_TYPE_OBJECT, true, Gender::class),
        ];
        yield [['type' => 'integer'], new Type(Type::BUILTIN_TYPE_INT)];
    }
}
