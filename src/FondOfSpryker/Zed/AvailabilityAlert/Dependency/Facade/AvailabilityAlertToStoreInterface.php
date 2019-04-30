<?php

namespace FondOfSpryker\Zed\AvailabilityAlert\Dependency\Facade;

interface AvailabilityAlertToStoreInterface
{
    /**
     * @param string $store
     *
     * @return \Generated\Shared\Transfer\StoreTransfer
     */
    public function getStore($store);
}
