<?php

/*
 * This file is part of the "elao/enum" package.
 *
 * Copyright (C) Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Enum\Tests\Fixtures\Bridge\Symfony\Workflow;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\Enum;

class WorkflowPlaceEnum extends Enum
{
    use AutoDiscoveredValuesTrait;

    const FIRST_PLACE = 'first_place';
    const SECOND_PLACE = 'second_place';
}
