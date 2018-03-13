<?php

namespace FondOfSpryker\Zed\AvailabilityAlert\Dependency\Facade;

interface AvailabilityAlertToLocaleInterface
{
    /**
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\LocaleTransfer
     */
    public function getLocale($localeName);
}
