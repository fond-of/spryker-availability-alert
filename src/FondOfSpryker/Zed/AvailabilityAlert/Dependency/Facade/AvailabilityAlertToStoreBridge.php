<?php

namespace FondOfSpryker\Zed\AvailabilityAlert\Dependency\Facade;

class AvailabilityAlertToStoreBridge implements AvailabilityAlertToStoreInterface
{
    /**
     * @var \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    protected $storeFacade;

    /**
     * @param \Spryker\Zed\Store\Business\StoreFacadeInterface $storeFacade
     */
    public function __construct($storeFacade)
    {
        $this->storeFacade = $storeFacade;
    }

    /**
     * @param string $store
     *
     * @return \Generated\Shared\Transfer\StoreTransfer
     */
    public function getStore($store)
    {
        return $this->storeFacade->getStoreByName($store);
    }
}
