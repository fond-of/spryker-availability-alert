<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscribersNotifier;

use Generated\Shared\Transfer\AvailabilityAlertSubscriptionTransfer;

class SubscribersNotifierPluginExecutor implements SubscribersNotifierPluginExecutorInterface
{
    /**
     * @var \FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscribersNotifier\SubscribersNotifierPreCheckPluginInterface[] $subscribersNotifierPreCheckPlugins
     */
    protected $subscribersNotifierPreCheckPlugins;

    /**
     * @param \FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscribersNotifier\SubscribersNotifierPreCheckPluginInterface[] $subscribersNotifierPreCheckPlugins
     */
    public function __construct(array $subscribersNotifierPreCheckPlugins)
    {
        $this->subscribersNotifierPreCheckPlugins = $subscribersNotifierPreCheckPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\AvailabilityAlertSubscriptionTransfer $availabilityAlertSubscriptionTransfer
     *
     * @return bool
     */
    public function executePreCheckPlugins(AvailabilityAlertSubscriptionTransfer $availabilityAlertSubscriptionTransfer): bool
    {
        foreach ($this->subscribersNotifierPreCheckPlugins as $subscribersNotifierPreCheckPlugin) {
            $isPassed = $subscribersNotifierPreCheckPlugin->checkCondition($availabilityAlertSubscriptionTransfer);

            if ($isPassed === false) {
                return false;
            }
        }

        return true;
    }
}
