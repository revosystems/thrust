<?php

declare(strict_types=1);

namespace BadChoice\Thrust\Fields;

use BadChoice\Thrust\Contracts\ThrustStatus;

class Status extends Field
{
    public function displayInIndex($object)
    {
        $status = $this->getValue($object);

        if (!($status instanceof ThrustStatus) || !($status instanceof \BackedEnum)) {
            return '';
        }

        return $status->thrustStatus()->html(
            $status->thrustStatusTooltipDescription(),
        );
    }

    public function displayInEdit($object, $inline = false)
    {
        return $this->displayInIndex($object);
    }
}
