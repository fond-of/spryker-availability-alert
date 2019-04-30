<?php

namespace FondOfSpryker\Zed\AvailabilityAlert\Communication\Controller\Mapper;

use FondOfSpryker\Zed\AvailabilityAlert\Dependency\Facade\AvailabilityAlertToLocaleInterface;
use FondOfSpryker\Zed\AvailabilityAlert\Dependency\Facade\AvailabilityAlertToStoreInterface;
use Generated\Shared\Transfer\AvailabilityAlertSubscriptionRequestTransfer;
use Generated\Shared\Transfer\AvailabilityAlertSubscriptionTransfer;

class AvailabilityAlertSubscriptionSubmitMapper implements AvailabilityAlertSubscriptionSubmitMapperInterface
{
    /**
     * @var \FondOfSpryker\Zed\AvailabilityAlert\Dependency\Facade\AvailabilityAlertToLocaleInterface
     */
    protected $localeFacade;

    /**
     * @var \FondOfSpryker\Zed\AvailabilityAlert\Dependency\Facade\AvailabilityAlertToStoreInterface
     */
    protected $storeFacade;

    /**
     * @param \FondOfSpryker\Zed\AvailabilityAlert\Dependency\Facade\AvailabilityAlertToLocaleInterface $localeFacade
     */
    public function __construct(
        AvailabilityAlertToLocaleInterface $localeFacade,
        AvailabilityAlertToStoreInterface $storeFacade
    ) {
        $this->localeFacade = $localeFacade;
        $this->storeFacade = $storeFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\AvailabilityAlertSubscriptionRequestTransfer $availabilityAlertSubscriptionRequestTransfer
     *
     * @return \Generated\Shared\Transfer\AvailabilityAlertSubscriptionTransfer
     */
    public function mapRequestTransfer(
        AvailabilityAlertSubscriptionRequestTransfer $availabilityAlertSubscriptionRequestTransfer
    ) {

        $this->assertAvailabilityAlertSubscriptionRequestTransfer($availabilityAlertSubscriptionRequestTransfer);

        $availabilityAlertSubscriptionTransfer = new AvailabilityAlertSubscriptionTransfer();

        $availabilityAlertSubscriptionTransfer
            ->fromArray($availabilityAlertSubscriptionRequestTransfer->modifiedToArray(), true)
            ->setFkProductAbstract($availabilityAlertSubscriptionRequestTransfer->getIdProductAbstract())
            ->setFkLocale($this->getIdLocale($availabilityAlertSubscriptionRequestTransfer))
            ->setFkStore($this->getIdStore($availabilityAlertSubscriptionRequestTransfer));
        
        return $availabilityAlertSubscriptionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\AvailabilityAlertSubscriptionRequestTransfer $availabilityAlertSubscriptionRequestTransfer
     *
     * @return string
     */
    protected function getIdLocale(
        AvailabilityAlertSubscriptionRequestTransfer $availabilityAlertSubscriptionRequestTransfer
    ) {
        return $this->localeFacade->getLocale($availabilityAlertSubscriptionRequestTransfer->getLocaleName())->getIdLocale();
    }

    /**
     * @param \Generated\Shared\Transfer\AvailabilityAlertSubscriptionRequestTransfer $availabilityAlertSubscriptionRequestTransfer
     *
     * @return string
     */
    protected function getIdStore(
        AvailabilityAlertSubscriptionRequestTransfer $availabilityAlertSubscriptionRequestTransfer
    ) {

        return $this->storeFacade->getStore($availabilityAlertSubscriptionRequestTransfer->getStore())->getIdStore();
    }

    /**
     * @param \Generated\Shared\Transfer\AvailabilityAlertSubscriptionRequestTransfer $availabilityAlertSubscriptionRequestTransfer
     *
     * @return void
     */
    protected function assertAvailabilityAlertSubscriptionRequestTransfer(
        AvailabilityAlertSubscriptionRequestTransfer $availabilityAlertSubscriptionRequestTransfer
    ) {
        $availabilityAlertSubscriptionRequestTransfer
            ->requireIdProductAbstract()
            ->requireEmail()
            ->requireLocaleName();
    }
}
