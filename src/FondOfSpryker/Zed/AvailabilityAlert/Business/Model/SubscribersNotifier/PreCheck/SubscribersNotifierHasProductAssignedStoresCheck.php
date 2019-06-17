<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscribersNotifier\PreCheck;

use FondOfSpryker\Zed\AvailabilityAlert\Dependency\Facade\AvailabilityAlertToProductInterface;
use Generated\Shared\Transfer\AvailabilityAlertSubscriptionTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;

class SubscribersNotifierHasProductAssignedStoresCheck implements SubscribersNotifierHasProductAssignedStoresCheckInterface
{
    /**
     * @var \FondOfSpryker\Zed\AvailabilityAlert\Dependency\Facade\AvailabilityAlertToProductInterface
     */
    protected $availabilityAlertToProduct;

    /**
     * @param \FondOfSpryker\Zed\AvailabilityAlert\Dependency\Facade\AvailabilityAlertToProductInterface $availabilityAlertToProduct
     */
    public function __construct(AvailabilityAlertToProductInterface $availabilityAlertToProduct)
    {
        $this->availabilityAlertToProduct = $availabilityAlertToProduct;
    }

    /**
     * @param \Generated\Shared\Transfer\AvailabilityAlertSubscriptionTransfer $availabilityAlertSubscriptionTransfer
     *
     * @return bool
     */
    public function checkHasProductAssignedStores(AvailabilityAlertSubscriptionTransfer $availabilityAlertSubscriptionTransfer): bool
    {
        $abstractProductTransfer = $this->getProductAbstractTransfer($availabilityAlertSubscriptionTransfer);
        if ($abstractProductTransfer) {
            return $this->hasAbstractProductAssignedStores($abstractProductTransfer);
        }

        return false;
    }

    /**
     * @param \Generated\Shared\Transfer\AvailabilityAlertSubscriptionTransfer $availabilityAlertSubscriptionTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer|null
     */
    protected function getProductAbstractTransfer(AvailabilityAlertSubscriptionTransfer $availabilityAlertSubscriptionTransfer): ?ProductAbstractTransfer
    {
        return $this->availabilityAlertToProduct->findProductAbstractById($availabilityAlertSubscriptionTransfer->getFkProductAbstract());
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return bool
     */
    protected function hasAbstractProductAssignedStores(ProductAbstractTransfer $productAbstractTransfer): bool
    {
        return count($productAbstractTransfer->getStoreRelation()->getIdStores()) !== 0;
    }
}
