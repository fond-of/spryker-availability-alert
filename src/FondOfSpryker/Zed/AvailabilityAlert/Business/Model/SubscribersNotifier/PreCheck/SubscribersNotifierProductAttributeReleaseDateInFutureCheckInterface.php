<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscribersNotifier\PreCheck;

use Generated\Shared\Transfer\AvailabilityAlertSubscriptionTransfer;

interface SubscribersNotifierProductAttributeReleaseDateInFutureCheckInterface
{
    /**
     * @param \Generated\Shared\Transfer\AvailabilityAlertSubscriptionTransfer $availabilityAlertSubscriptionTransfer
     *
     * @return bool
     */
    public function checkHasProductAttributeReleaseDateInFuture(AvailabilityAlertSubscriptionTransfer $availabilityAlertSubscriptionTransfer): bool;
}
