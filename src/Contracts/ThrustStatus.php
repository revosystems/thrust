<?php

declare(strict_types=1);

namespace BadChoice\Thrust\Contracts;

use BadChoice\Thrust\Enums\Status;

interface ThrustStatus
{
    public function thrustStatus(): Status;
    public function thrustStatusTooltipDescription(): string;
}
