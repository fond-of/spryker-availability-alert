<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscribersNotifier\PreCheck;

use DateTimeImmutable;
use DateTimeInterface;
use FondOfSpryker\Zed\AvailabilityAlert\Dependency\Facade\AvailabilityAlertToProductInterface;
use Generated\Shared\Transfer\AvailabilityAlertSubscriptionTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;

class SubscribersNotifierProductAttributeReleaseDateInFutureCheck implements SubscribersNotifierProductAttributeReleaseDateInFutureCheckInterface
{
    protected const PRODUCT_ATTRIBUTE_RELEASE_DATE = 'release_date';

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
    public function checkHasProductAttributeReleaseDateInFuture(AvailabilityAlertSubscriptionTransfer $availabilityAlertSubscriptionTransfer): bool
    {
        $productAbstractTransfer = $this->getProductAbstractTransfer($availabilityAlertSubscriptionTransfer);
        if ($productAbstractTransfer === null) {
            return false;
        }

        if ($this->hasProductAttributeReleaseDate($productAbstractTransfer)) {
            return $this->isDateTimeInFuture($this->getProductAttributeReleaseDate($productAbstractTransfer)) === false;
        }

        return true;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return bool
     */
    protected function hasProductAttributeReleaseDate(ProductAbstractTransfer $productAbstractTransfer): bool
    {
        return array_key_exists(static::PRODUCT_ATTRIBUTE_RELEASE_DATE, $productAbstractTransfer->getAttributes())
            && $productAbstractTransfer->getAttributes()[static::PRODUCT_ATTRIBUTE_RELEASE_DATE] !== ''
            && $productAbstractTransfer->getAttributes()[static::PRODUCT_ATTRIBUTE_RELEASE_DATE] !== null;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @throws
     *
     * @return \DateTimeInterface
     */
    protected function getProductAttributeReleaseDate(ProductAbstractTransfer $productAbstractTransfer): DateTimeInterface
    {
        return new DateTimeImmutable($productAbstractTransfer->getAttributes()[static::PRODUCT_ATTRIBUTE_RELEASE_DATE]);
    }

    /**
     * @param \DateTimeInterface $compareDateTime
     *
     * @throws
     *
     * @return bool
     */
    protected function isDateTimeInFuture(DateTimeInterface $compareDateTime): bool
    {
        return $compareDateTime < new DateTimeImmutable();
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
}
