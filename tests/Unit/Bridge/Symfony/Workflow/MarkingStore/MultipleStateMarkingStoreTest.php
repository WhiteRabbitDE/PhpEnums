<?php

/*
 * This file is part of the "elao/enum" package.
 *
 * Copyright (C) Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Enum\Tests\Unit\Bridge\Symfony\Workflow\MarkingStore;

use Elao\Enum\Bridge\Symfony\Workflow\MarkingStore\MultipleStateMarkingStore;
use Elao\Enum\Tests\Fixtures\Bridge\Symfony\Workflow\WorkflowPlaceEnum;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Workflow\Marking;

class MultipleStateMarkingStoreTest extends TestCase
{
    public function testGetSetMarking()
    {
        $subject = new \stdClass();
        $subject->myMarks = null;

        $markingStore = new MultipleStateMarkingStore(WorkflowPlaceEnum::class, 'myMarks');

        $marking = $markingStore->getMarking($subject);

        $this->assertInstanceOf(Marking::class, $marking);
        $this->assertCount(0, $marking->getPlaces());

        $marking->mark('first_place');

        $markingStore->setMarking($subject, $marking);

        $this->assertSame([WorkflowPlaceEnum::get(WorkflowPlaceEnum::FIRST_PLACE)], $subject->myMarks);

        $marking2 = $markingStore->getMarking($subject);

        $this->assertEquals($marking, $marking2);
    }
}
