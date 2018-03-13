<?php

namespace FondOfSpryker\Client\AvailabilityAlert;

use Generated\Shared\Transfer\AvailabilityAlertSubscriptionRequestTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfSpryker\Client\AvailabilityAlert\AvailabilityAlertFactory getFactory()
 */
class AvailabilityAlertClient extends AbstractClient implements AvailabilityAlertClientInterface
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\AvailabilityAlertSubscriptionRequestTransfer $availabilityAlertRequestTransfer
     *
     * @return \Generated\Shared\Transfer\AvailabilityAlertSubscriptionResponseTransfer
     */
    public function subscribe(AvailabilityAlertSubscriptionRequestTransfer $availabilityAlertRequestTransfer)
    {
        return $this->getFactory()
            ->createAvailabilityAlertStub()
            ->subscribe($availabilityAlertRequestTransfer);
    }
}
