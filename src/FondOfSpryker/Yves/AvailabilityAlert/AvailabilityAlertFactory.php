<?php

namespace FondOfSpryker\Yves\AvailabilityAlert;

use FondOfSpryker\Yves\AvailabilityAlert\Form\DataProvider\SubscriptionFormDataProvider;
use FondOfSpryker\Yves\AvailabilityAlert\Form\SubscriptionForm;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Yves\Kernel\AbstractFactory;

class AvailabilityAlertFactory extends AbstractFactory
{
    /**
     * @param $idProductAbstract
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createSubscriptionForm($idProductAbstract)
    {
        $dataProvider = $this->createSubscriptionFormDataProvider();

        $form = $this->getFormFactory()->create(
            $this->getSubscriptionFormType(),
            $dataProvider->getData($idProductAbstract),
            $dataProvider->getOptions()
        );

        return $form;
    }

    /**
     * @return SubscriptionFormDataProvider
     */
    public function createSubscriptionFormDataProvider()
    {
        return new SubscriptionFormDataProvider();
    }

    /**
     * @return \Symfony\Component\Form\FormFactory
     */
    protected function getFormFactory()
    {
        return $this->getProvidedDependency(ApplicationConstants::FORM_FACTORY);
    }

    /**
     * @return string
     */
    protected function getSubscriptionFormType()
    {
        return SubscriptionForm::class;
    }

    /**
     * @return \FondOfSpryker\Client\AvailabilityAlert\AvailabilityAlertClientInterface
     */
    public function getAvailabilityAlertClient()
    {
        return $this->getProvidedDependency(AvailabilityAlertDependencyProvider::CLIENT_AVAILABILITY_ALERT);
    }
}
