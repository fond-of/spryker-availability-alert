<?php

namespace FondOfSpryker\Zed\AvailabilityAlert\Business;

use FondOfSpryker\Zed\AvailabilityAlert\AvailabilityAlertDependencyProvider;
use FondOfSpryker\Zed\AvailabilityAlert\Business\Model\MailHandler;
use FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscribersNotifier;
use FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscriptionManager;
use FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscriptionRequestHandler;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\AvailabilityAlert\AvailabilityAlertConfig getConfig()
 * @method \FondOfSpryker\Zed\AvailabilityAlert\Persistence\AvailabilityAlertQueryContainerInterface getQueryContainer()
 */
class AvailabilityAlertBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscriptionRequestHandler
     */
    public function createSubscriptionRequestHandler()
    {
        return new SubscriptionRequestHandler(
            $this->createSubscriptionManager(),
            $this->getQueryContainer()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscriptionManager
     */
    protected function createSubscriptionManager()
    {
        return new SubscriptionManager(
            $this->getQueryContainer()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscribersNotifier
     */
    public function createSubscribersNotifer()
    {
        $this->getAvalabilityFacade();
            $this->createMailHandler();
            $this->getQueryContainer();
            $this->getConfig()->getMinimalPercentageDifference();
        return new SubscribersNotifier(
            $this->getAvalabilityFacade(),
            $this->createMailHandler(),
            $this->getQueryContainer(),
            $this->getConfig()->getMinimalPercentageDifference()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\AvailabilityAlert\Business\Model\MailHandler
     */
    protected function createMailHandler()
    {
        $mailHandler = new MailHandler(
            $this->getMailFacade()
        );

        return $mailHandler;
    }

    /**
     * @return \FondOfSpryker\Zed\AvailabilityAlert\Dependency\Facade\AvailabilityAlertToMailInterface
     */
    protected function getMailFacade()
    {
        return $this->getProvidedDependency(AvailabilityAlertDependencyProvider::FACADE_MAIL);
    }

    /**
     * @return \Spryker\Zed\Availability\Business\AvailabilityFacadeInterface
     */
    protected function getAvalabilityFacade()
    {
        return $this->getProvidedDependency(AvailabilityAlertDependencyProvider::FACADE_AVAILABILITY);
    }
}
