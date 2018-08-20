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
 * SingleStateMarkingStore from {@link https://github.com/symfony/symfony/blob/master/src/Symfony/Component/Workflow/MarkingStore/SingleStateMarkingStore.php Symfony's one}
 * with extra enum support.
 *
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
class SingleStateMarkingStore implements MarkingStoreInterface
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
        /** @var EnumInterface|null $placeAsEnum */
        $placeAsEnum = $this->propertyAccessor->getValue($subject, $this->property);

        if (!$placeAsEnum) {
            return new Marking();
        }

        return new Marking([$placeAsEnum->getValue() => 1]);
    }

    /**
     * {@inheritdoc}
     */
    public function setMarking($subject, Marking $marking)
    {
        $placeName = key($marking->getPlaces());
        $placeAsEnum = $placeName ? $this->enumClass::get($placeName) : null;

        $this->propertyAccessor->setValue($subject, $this->property, $placeAsEnum);
    }

    /**
     * @return string
     */
    public function getProperty()
    {
        return $this->property;
    }
}
