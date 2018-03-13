<?php

namespace FondOfSpryker\Zed\AvailabilityAlert;

use FondOfSpryker\Shared\AvailabilityAlert\AvailabilityAlertConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class AvailabilityAlertConfig extends AbstractBundleConfig
{
    /**
     * @return int
     */
    public function getMinimalPercentageDifference(): int
    {
        return $this->get(
            AvailabilityAlertConstants::MINIMAL_PERCENTAGE_DIFFERENCE,
            AvailabilityAlertConstants::MINIMAL_PERCENTAGE_DIFFERENCE_VALUE
        );
    }
}
