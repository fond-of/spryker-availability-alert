<?php

namespace FondOfSpryker\Zed\AvailabilityAlert\Business;

use Generated\Shared\Transfer\AvailabilityAlertSubscriptionTransfer;

interface AvailabilityAlertFacadeInterface
{
    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\AvailabilityAlertSubscriptionTransfer $availabilityAlertSubscriptionTransfer
     *
     * @return \Generated\Shared\Transfer\AvailabilityAlertSubscriptionResponseTransfer
     */
    public function subscribe(AvailabilityAlertSubscriptionTransfer $availabilityAlertSubscriptionTransfer);

    /**
     * @api
     *
     * @return void
     */
    public function notifySubscribers();
}
