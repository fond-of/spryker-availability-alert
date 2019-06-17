<?php

namespace FondOfSpryker\Zed\AvailabilityAlert\Business\Model;

interface SubscribersNotifierInterface
{
    /**
     * @return \FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscribersNotifierInterface
     */
    public function notify(): SubscribersNotifierInterface;
}
