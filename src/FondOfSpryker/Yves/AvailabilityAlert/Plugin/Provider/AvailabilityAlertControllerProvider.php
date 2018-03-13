<?php

namespace FondOfSpryker\Yves\AvailabilityAlert\Plugin\Provider;

use Pyz\Yves\Application\Plugin\Provider\AbstractYvesControllerProvider;
use Silex\Application;

class AvailabilityAlertControllerProvider extends AbstractYvesControllerProvider
{
    const ROUTE_AVAILABILITY_ALERT_SUBMIT = 'availability-alert/submit';

    const ID_ABSTRACT_PRODUCT_REGEX = '[1-9][0-9]*';

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    protected function defineControllers(Application $app)
    {
        $allowedLocalesPattern = $this->getAllowedLocalesPattern();

        $this->createController('/{availabilityAlert}/submit/{idProductAbstract}', static::ROUTE_AVAILABILITY_ALERT_SUBMIT, 'AvailabilityAlert', 'Submit', 'index')
            ->assert('availabilityAlert', $allowedLocalesPattern . 'availability-alert|availability-alert')
            ->value('availabilityAlert', 'availability-alert')
            ->assert('idProductAbstract', static::ID_ABSTRACT_PRODUCT_REGEX);
    }
}
