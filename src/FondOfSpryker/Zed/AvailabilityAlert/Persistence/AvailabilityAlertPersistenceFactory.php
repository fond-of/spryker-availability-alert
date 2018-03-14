<?php

namespace FondOfSpryker\Zed\AvailabilityAlert\Persistence;

use Orm\Zed\AvailabilityAlert\Persistence\FosAvailabilityAlertSubscriptionQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfSpryker\Zed\AvailabilityAlert\AvailabilityAlertConfig getConfig()
 * @method \FondOfSpryker\Zed\AvailabilityAlert\Persistence\AvailabilityAlertQueryContainerInterface getQueryContainer()
 */
class AvailabilityAlertPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\AvailabilityAlert\Persistence\FosAvailabilityAlertSubscriptionQuery
     */
    public function createAvailabilityAlertSubscriptionQuery()
    {
        return FosAvailabilityAlertSubscriptionQuery::create();
    }
}
