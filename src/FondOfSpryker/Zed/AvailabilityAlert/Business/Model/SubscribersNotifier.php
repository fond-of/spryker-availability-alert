<?php

namespace FondOfSpryker\Zed\AvailabilityAlert\Business\Model;

use FondOfSpryker\Zed\AvailabilityAlert\Persistence\AvailabilityAlertQueryContainerInterface;
use Orm\Zed\AvailabilityAlert\Persistence\FosAvailabilityAlertSubscription;
use Orm\Zed\AvailabilityAlert\Persistence\Map\FosAvailabilityAlertSubscriptionTableMap;
use Spryker\Zed\Availability\Business\AvailabilityFacadeInterface;

class SubscribersNotifier implements SubscribersNotifierInterface
{
    /**
     * @var AvailabilityFacadeInterface
     */
    protected $availabilityFacade;

    /**
     * @var \FondOfSpryker\Zed\AvailabilityAlert\Persistence\AvailabilityAlertQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @var MailHandler
     */
    protected $mailHandler;

    /**
     * @var int
     */
    protected $minimalPercentageDifference;

    /**
     * @param AvailabilityFacadeInterface $availabilityFacade
     * @param MailHandler $mailHandler
     * @param AvailabilityAlertQueryContainerInterface $queryContainer
     * @param $minimalPercentageDifference
     */
    public function __construct(
        AvailabilityFacadeInterface $availabilityFacade,
        MailHandler $mailHandler,
        AvailabilityAlertQueryContainerInterface $queryContainer,
        $minimalPercentageDifference
    ) {
        $this->availabilityFacade = $availabilityFacade;
        $this->mailHandler = $mailHandler;
        $this->queryContainer = $queryContainer;
        $this->minimalPercentageDifference = $minimalPercentageDifference;
    }

    /**
     * @return SubscribersNotifier
     */
    public function notify()
    {
        $countOfSubscriberPerProductAbstract = $this->getCountOfSubscriberPerProductAbstract();

        foreach ($this->getSubscritpions() as $fosAvailabilityAlertSubscription) {
            if (!$this->canSendNotification($fosAvailabilityAlertSubscription, $countOfSubscriberPerProductAbstract)) {
                continue;
            }

            $this->sendNotification($fosAvailabilityAlertSubscription);
        }

        return $this;
    }

    /**
     * @param FosAvailabilityAlertSubscription $fosAvailabilityAlertSubscription
     *
     * @return SubscribersNotifier
     */
    protected function sendNotification(FosAvailabilityAlertSubscription $fosAvailabilityAlertSubscription)
    {
        $this->mailHandler->sendAvailabilityAlertMail($fosAvailabilityAlertSubscription);

        /*$fosAvailabilityAlertSubscription->setSentAt(new \DateTime())
            ->setStatus(FosAvailabilityAlertSubscriptionTableMap::COL_STATUS_NOTIFIED)
            ->save();*/

        return $this;
    }

    /**
     * @param FosAvailabilityAlertSubscription $fosAvailabilityAlertSubscription
     * @param $countOfSubscriberPerProductAbstract
     *
     * @return bool
     */
    protected function canSendNotification(
        FosAvailabilityAlertSubscription $fosAvailabilityAlertSubscription,
        $countOfSubscriberPerProductAbstract
    )
    {
        $percentageDifference = $this->calculatePercentageDifference(
            $fosAvailabilityAlertSubscription,
            $countOfSubscriberPerProductAbstract
        );

        return $percentageDifference < $this->minimalPercentageDifference;
    }

    /**
     * @param FosAvailabilityAlertSubscription $fosAvailabilityAlertSubscription
     * @param $countOfSubscriberPerProductAbstract
     *
     * @return float|int
     */
    protected function calculatePercentageDifference(
        FosAvailabilityAlertSubscription $fosAvailabilityAlertSubscription,
        $countOfSubscriberPerProductAbstract
    ) {
        $fkProductAbstract = $fosAvailabilityAlertSubscription->getFkProductAbstract();
        $subscriberCount = $countOfSubscriberPerProductAbstract[$fkProductAbstract];
        $availability = $this->getAvailability($fosAvailabilityAlertSubscription);

        return $availability * 100 / $subscriberCount;
    }

    /**
     * @param FosAvailabilityAlertSubscription $fosAvailabilityAlertSubscription
     *
     * @return int
     */
    protected function getAvailability(
        FosAvailabilityAlertSubscription $fosAvailabilityAlertSubscription
    ) {
        $productAbstractAvailability = $this->availabilityFacade->getProductAbstractAvailability(
            $fosAvailabilityAlertSubscription->getFkProductAbstract(),
            $fosAvailabilityAlertSubscription->getFkLocale()
        );

        return $productAbstractAvailability->getAvailability();
    }

    /**
     * @return FosAvailabilityAlertSubscription[]|\Propel\Runtime\Collection\ObjectCollection
     */
    protected function getSubscritpions()
    {
        return $this->queryContainer->querySubscriptionsByStatus(0)
            ->find();
    }

    /**
     * @return array
     */
    protected function getCountOfSubscriberPerProductAbstract()
    {
        return $this->queryContainer->queryCountOfSubscriberPerProductAbstract()
            ->find()
            ->toKeyValue(FosAvailabilityAlertSubscriptionTableMap::COL_FK_PRODUCT_ABSTRACT, 'count_of_subscriber');
    }
}
