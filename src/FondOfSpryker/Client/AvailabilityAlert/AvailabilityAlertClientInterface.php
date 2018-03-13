<?php

namespace FondOfSpryker\Client\AvailabilityAlert;

use Generated\Shared\Transfer\AvailabilityAlertSubscriptionRequestTransfer;

interface AvailabilityAlertClientInterface
{
    /**
     * Specification:
     * - Stores provided availability alert in persistent storage with pending status.
     * - Returns the provided transfer object updated with the stored entity's data.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\AvailabilityAlertSubscriptionRequestTransfer $availabilityAlertRequestTransfer
     *
     * @return \Generated\Shared\Transfer\AvailabilityAlertSubscriptionResponseTransfer
     */
    public function subscribe(AvailabilityAlertSubscriptionRequestTransfer $availabilityAlertRequestTransfer);
}
