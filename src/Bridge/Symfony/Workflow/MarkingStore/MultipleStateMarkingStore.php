<?php

/*
 * This file is part of the "elao/enum" package.
 *
 * Copyright (C) Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Enum\Bridge\Symfony\Workflow\MarkingStore;

use Elao\Enum\EnumInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Workflow\Marking;
use Symfony\Component\Workflow\MarkingStore\MarkingStoreInterface;

/**
 * MultipleStateMarkingStore from {@link https://github.com/symfony/symfony/blob/master/src/Symfony/Component/Workflow/MarkingStore/MultipleStateMarkingStore.php Symfony's one}
 * with extra enum support.
 *
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
class MultipleStateMarkingStore implements MarkingStoreInterface
{
    private $property;
    private $propertyAccessor;

    /** @var string|EnumInterface */
    private $enumClass;

    public function __construct(
        string $enumClass,
        string $property = 'marking',
        PropertyAccessorInterface $propertyAccessor = null
    ) {
        $this->enumClass = $enumClass;
        $this->property = $property;
        $this->propertyAccessor = $propertyAccessor ?? PropertyAccess::createPropertyAccessor();
    }

    /**
     * {@inheritdoc}
     */
    public function getMarking($subject)
    {
        /** @var EnumInterface[] $placesAsEnums */
        $placesAsEnums = $this->propertyAccessor->getValue($subject, $this->property) ?? [];
        $representation = [];
        foreach ($placesAsEnums as $placeAsEnum) {
            $representation[$placeAsEnum->getValue()] = 1;
        }

        return new Marking($representation);
    }

    /**
     * {@inheritdoc}
     */
    public function setMarking($subject, Marking $marking)
    {
        $placeNames = array_keys($marking->getPlaces());

        $this->propertyAccessor->setValue($subject, $this->property, array_map(function ($value): EnumInterface {
            return $this->enumClass::get($value);
        }, $placeNames));
    }

    /**
     * @return string
     */
    public function getProperty()
    {
        return $this->property;
    }
}
