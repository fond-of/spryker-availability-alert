<?php

namespace FondOfSpryker\Zed\AvailabilityAlert\Communication;

use FondOfSpryker\Zed\AvailabilityAlert\AvailabilityAlertDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use FondOfSpryker\Zed\AvailabilityAlert\Communication\Controller\Mapper\AvailabilityAlertSubscriptionSubmitMapper;

/**
 * @method \FondOfSpryker\Zed\AvailabilityAlert\AvailabilityAlertConfig getConfig()
 * @method \FondOfSpryker\Zed\AvailabilityAlert\Persistence\AvailabilityAlertQueryContainerInterface getQueryContainer()
 */
class AvailabilityAlertCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfSpryker\Zed\AvailabilityAlert\Communication\Controller\Mapper\AvailabilityAlertSubscriptionSubmitMapperInterface
     */
    public function createAvailabilityAlertSubscriptionSubmitMapper()
    {
        return new AvailabilityAlertSubscriptionSubmitMapper($this->getLocaleFacade());
    }

    /**
     * @return \FondOfSpryker\Zed\AvailabilityAlert\Dependency\Facade\AvailabilityAlertToLocaleInterface
     */
    protected function getLocaleFacade()
    {
        return $this->getProvidedDependency(AvailabilityAlertDependencyProvider::FACADE_LOCALE);
    }
}
