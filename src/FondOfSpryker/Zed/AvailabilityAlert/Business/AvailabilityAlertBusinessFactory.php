<?php

namespace FondOfSpryker\Zed\AvailabilityAlert\Business;

use FondOfSpryker\Zed\AvailabilityAlert\AvailabilityAlertDependencyProvider;
use FondOfSpryker\Zed\AvailabilityAlert\Business\Model\MailHandler;
use FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscribersNotifier;
use FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscribersNotifier\PreCheck\SubscribersNotifierHasProductAssignedStoresCheck;
use FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscribersNotifier\PreCheck\SubscribersNotifierHasProductAssignedStoresCheckInterface;
use FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscribersNotifier\PreCheck\SubscribersNotifierProductAttributeReleaseDateInPastOrIsEmptyCheck;
use FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscribersNotifier\PreCheck\SubscribersNotifierProductAttributeReleaseDateInPastOrIsEmptyCheckInterface;
use FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscribersNotifier\SubscribersNotifierPluginExecutor;
use FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscribersNotifier\SubscribersNotifierPluginExecutorInterface;
use FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscribersNotifierInterface;
use FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscriptionManager;
use FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscriptionManagerInterface;
use FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscriptionRequestHandler;
use FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscriptionRequestHandlerInterface;
use FondOfSpryker\Zed\AvailabilityAlert\Dependency\Facade\AvailabilityAlertToMailInterface;
use FondOfSpryker\Zed\AvailabilityAlert\Dependency\Facade\AvailabilityAlertToProductInterface;
use Spryker\Zed\Availability\Business\AvailabilityFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\AvailabilityAlert\AvailabilityAlertConfig getConfig()
 * @method \FondOfSpryker\Zed\AvailabilityAlert\Persistence\AvailabilityAlertQueryContainerInterface getQueryContainer()
 */
class AvailabilityAlertBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscriptionRequestHandlerInterface
     */
    public function createSubscriptionRequestHandler(): SubscriptionRequestHandlerInterface
    {
        return new SubscriptionRequestHandler(
            $this->createSubscriptionManager()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscriptionManagerInterface
     */
    protected function createSubscriptionManager(): SubscriptionManagerInterface
    {
        return new SubscriptionManager(
            $this->getQueryContainer()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscribersNotifierInterface
     */
    public function createSubscribersNotifer(): SubscribersNotifierInterface
    {
        return new SubscribersNotifier(
            $this->getAvailabilityFacade(),
            $this->createMailHandler(),
            $this->getQueryContainer(),
            $this->getConfig()->getMinimalPercentageDifference(),
            $this->createSubscribersNotifierPluginExecutor()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\AvailabilityAlert\Business\Model\MailHandler
     */
    protected function createMailHandler(): MailHandler
    {
        return new MailHandler(
            $this->getMailFacade(),
            $this->getProductFacade(),
            $this->getConfig()->getBaseUrlSslYves()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscribersNotifier\SubscribersNotifierPluginExecutorInterface
     */
    protected function createSubscribersNotifierPluginExecutor(): SubscribersNotifierPluginExecutorInterface
    {
        return new SubscribersNotifierPluginExecutor(
            $this->getSubscribersNotifierPreCheckPlugins()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscribersNotifier\PreCheck\SubscribersNotifierHasProductAssignedStoresCheckInterface
     */
    public function createSubscribersNotifierHasProductAssignedStoresCheck(): SubscribersNotifierHasProductAssignedStoresCheckInterface
    {
        return new SubscribersNotifierHasProductAssignedStoresCheck(
            $this->getProductFacade()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscribersNotifier\PreCheck\SubscribersNotifierProductAttributeReleaseDateInPastOrIsEmptyCheckInterface
     */
    public function createSubscribersNotifierProductAttributeReleaseDateInPastOrIsEmptyCheck(): SubscribersNotifierProductAttributeReleaseDateInPastOrIsEmptyCheckInterface
    {
        return new SubscribersNotifierProductAttributeReleaseDateInPastOrIsEmptyCheck(
            $this->getProductFacade()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\AvailabilityAlert\Dependency\Facade\AvailabilityAlertToMailInterface
     */
    protected function getMailFacade(): AvailabilityAlertToMailInterface
    {
        return $this->getProvidedDependency(AvailabilityAlertDependencyProvider::FACADE_MAIL);
    }

    /**
     * @return \FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscribersNotifier\SubscribersNotifierPreCheckPluginInterface[]
     */
    protected function getSubscribersNotifierPreCheckPlugins(): array
    {
        return $this->getProvidedDependency(AvailabilityAlertDependencyProvider::SUBSCRIBERS_NOTIFIER_PRE_CHECK_PLUGINS);
    }

    /**
     * @return \Spryker\Zed\Availability\Business\AvailabilityFacadeInterface
     */
    protected function getAvailabilityFacade(): AvailabilityFacadeInterface
    {
        return $this->getProvidedDependency(AvailabilityAlertDependencyProvider::FACADE_AVAILABILITY);
    }

    /**
     * @return \FondOfSpryker\Zed\AvailabilityAlert\Dependency\Facade\AvailabilityAlertToProductInterface
     */
    protected function getProductFacade(): AvailabilityAlertToProductInterface
    {
        return $this->getProvidedDependency(AvailabilityAlertDependencyProvider::FACADE_PRODUCT);
    }
}
