<?php

namespace FondOfSpryker\Zed\AvailabilityAlert\Business\Model;

use FondOfSpryker\Zed\AvailabilityAlert\Communication\Plugin\Mail\AvailabilityAlertMailTypePlugin;
use FondOfSpryker\Zed\AvailabilityAlert\Dependency\Facade\AvailabilityAlertToMailInterface;
use Generated\Shared\Transfer\AvailabilityAlertSubscriptionTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Orm\Zed\AvailabilityAlert\Persistence\FosAvailabilityAlertSubscription;

class MailHandler
{
    /**
     * @param \FondOfSpryker\Zed\AvailabilityAlert\Dependency\Facade\AvailabilityAlertToMailInterface $mailFacade
     */
    public function __construct(AvailabilityAlertToMailInterface $mailFacade)
    {
        $this->mailFacade = $mailFacade;
    }

    /**
     * @param \Orm\Zed\AvailabilityAlert\Persistence\FosAvailabilityAlertSubscription $fosAvailabilityAlertSubscription
     *
     * @return void
     */
    public function sendAvailabilityAlertMail(FosAvailabilityAlertSubscription $fosAvailabilityAlertSubscription)
    {
        $availabilityAlertSubscriptionTransfer = $this->getAvailabilityAlertSubscriptionTransfer($fosAvailabilityAlertSubscription);
        $localeTransfer = $this->getLocaleTransfer($fosAvailabilityAlertSubscription);
        $productAbstractTransfer = $this->getProductAbstractTransfer($fosAvailabilityAlertSubscription);

        $mailTransfer = new MailTransfer();
        $mailTransfer->setAvailabilityAlertSubscription($availabilityAlertSubscriptionTransfer);
        $mailTransfer->setLocale($localeTransfer);
        $mailTransfer->setProductAbstract($productAbstractTransfer);
        $mailTransfer->setType(AvailabilityAlertMailTypePlugin::MAIL_TYPE);

        $this->mailFacade->handleMail($mailTransfer);
    }

    /**
     * @param \Orm\Zed\AvailabilityAlert\Persistence\FosAvailabilityAlertSubscription $fosAvailabilityAlertSubscription
     *
     * @return \Generated\Shared\Transfer\AvailabilityAlertSubscriptionTransfer
     */
    protected function getAvailabilityAlertSubscriptionTransfer(
        FosAvailabilityAlertSubscription $fosAvailabilityAlertSubscription
    ) {
        $availabilityAlertSubscriptionTransfer = new AvailabilityAlertSubscriptionTransfer();

        $availabilityAlertSubscriptionTransfer->fromArray($fosAvailabilityAlertSubscription->toArray(), true);

        return $availabilityAlertSubscriptionTransfer;
    }

    /**
     * @param \Orm\Zed\AvailabilityAlert\Persistence\FosAvailabilityAlertSubscription $fosAvailabilityAlertSubscription
     *
     * @return \Generated\Shared\Transfer\LocaleTransfer
     */
    protected function getLocaleTransfer(FosAvailabilityAlertSubscription $fosAvailabilityAlertSubscription)
    {
        $spyLocale = $fosAvailabilityAlertSubscription->getSpyLocale();

        $localeTransfer = new LocaleTransfer();

        $localeTransfer->fromArray($spyLocale->toArray(), true);

        return $localeTransfer;
    }

    /**
     * @param \Orm\Zed\AvailabilityAlert\Persistence\FosAvailabilityAlertSubscription $fosAvailabilityAlertSubscription
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    protected function getProductAbstractTransfer(FosAvailabilityAlertSubscription $fosAvailabilityAlertSubscription)
    {
        $spyProductAbstract = $fosAvailabilityAlertSubscription->getSpyProductAbstract();

        $productAbstractTransfer = new ProductAbstractTransfer();

        $productAbstractTransfer->fromArray($spyProductAbstract->toArray(), true);

        return $productAbstractTransfer;
    }
}
