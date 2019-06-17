<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\AvailabilityAlert\Communication\Plugin\SubscribersNotifier;

use FondOfSpryker\Zed\AvailabilityAlert\AvailabilityAlertConfig;
use FondOfSpryker\Zed\AvailabilityAlert\Business\AvailabilityAlertFacadeInterface;
use FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscribersNotifier\SubscribersNotifierPreCheckPluginInterface;
use FondOfSpryker\Zed\AvailabilityAlert\Communication\AvailabilityAlertCommunicationFactory;
use Generated\Shared\Transfer\AvailabilityAlertSubscriptionTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method AvailabilityAlertFacadeInterface getFacade()
 * @method AvailabilityAlertCommunicationFactory getFactory()
 * @method AvailabilityAlertConfig getConfig()
 */
class SubscribersNotifierProductAttributeReleaseDateInPastOrIsEmptyPreCheckPlugin extends AbstractPlugin implements SubscribersNotifierPreCheckPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\AvailabilityAlertSubscriptionTransfer $availabilityAlertSubscriptionTransfer
     *
     * @return bool
     */
    public function checkCondition(AvailabilityAlertSubscriptionTransfer $availabilityAlertSubscriptionTransfer): bool
    {
        return $this->getFacade()->preCheckSubscribersNotifierProductAttributeReleaseDateInPastOrIsEmpty($availabilityAlertSubscriptionTransfer);
    }
}
