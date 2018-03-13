<?php

namespace FondOfSpryker\Zed\AvailabilityAlert\Communication\Controller;

use Generated\Shared\Transfer\AvailabilityAlertSubscriptionRequestTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \FondOfSpryker\Zed\AvailabilityAlert\Business\AvailabilityAlertFacadeInterface getFacade()
 * @method \FondOfSpryker\Zed\AvailabilityAlert\Communication\AvailabilityAlertCommunicationFactory getFactory()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @param \Generated\Shared\Transfer\AvailabilityAlertSubscriptionRequestTransfer $availabilityAlertSubscriptionRequestTransfer
     *
     * @return \Generated\Shared\Transfer\AvailabilityAlertSubscriptionResponseTransfer
     */
    public function subscribeAction(AvailabilityAlertSubscriptionRequestTransfer $availabilityAlertSubscriptionRequestTransfer)
    {
        $availabilityAlertSubscriptionTransfer = $this->getFactory()
            ->createAvailabilityAlertSubscriptionSubmitMapper()
            ->mapRequestTransfer($availabilityAlertSubscriptionRequestTransfer);

        return $this->getFacade()->subscribe($availabilityAlertSubscriptionTransfer);
    }
}
