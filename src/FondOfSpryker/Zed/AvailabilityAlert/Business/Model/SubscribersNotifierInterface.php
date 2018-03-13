<?php

namespace FondOfSpryker\Zed\AvailabilityAlert\Business\Model;

interface SubscribersNotifierInterface
{
    /**
     * @return SubscribersNotifier
     */
    public function notify();
}
