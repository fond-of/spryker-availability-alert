<?php

namespace FondOfSpryker\Zed\AvailabilityAlert\Business\Model;

use DateTime;
use FondOfSpryker\Zed\AvailabilityAlert\Persistence\AvailabilityAlertQueryContainerInterface;
use Orm\Zed\AvailabilityAlert\Persistence\FosAvailabilityAlertSubscription;
use Orm\Zed\AvailabilityAlert\Persistence\Map\FosAvailabilityAlertSubscriptionTableMap;
use Orm\Zed\Store\Persistence\SpyStoreQuery;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Availability\Business\AvailabilityFacadeInterface;

class SubscribersNotifier implements SubscribersNotifierInterface
{
    /**
     * @var \Spryker\Zed\Availability\Business\AvailabilityFacadeInterface
     */
    protected $availabilityFacade;

    /**
     * @var \FondOfSpryker\Zed\AvailabilityAlert\Persistence\AvailabilityAlertQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @var \FondOfSpryker\Zed\AvailabilityAlert\Business\Model\MailHandler
     */
    protected $mailHandler;

    /**
     * @var int
     */
    protected $minimalPercentageDifference;

    /**
     * @param \Spryker\Zed\Availability\Business\AvailabilityFacadeInterface $availabilityFacade
     * @param \FondOfSpryker\Zed\AvailabilityAlert\Business\Model\MailHandler $mailHandler
     * @param \FondOfSpryker\Zed\AvailabilityAlert\Persistence\AvailabilityAlertQueryContainerInterface $queryContainer
     * @param int $minimalPercentageDifference
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
     * @return \FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscribersNotifier
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
     * @param \Orm\Zed\AvailabilityAlert\Persistence\FosAvailabilityAlertSubscription $fosAvailabilityAlertSubscription
     *
     * @return \FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscribersNotifier
     */
    protected function sendNotification(FosAvailabilityAlertSubscription $fosAvailabilityAlertSubscription)
    {
        $this->mailHandler->sendAvailabilityAlertMail($fosAvailabilityAlertSubscription);

        $fosAvailabilityAlertSubscription->setSentAt(new DateTime())
            ->setStatus(FosAvailabilityAlertSubscriptionTableMap::COL_STATUS_NOTIFIED)
            ->save();

        return $this;
    }

    /**
     * @param \Orm\Zed\AvailabilityAlert\Persistence\FosAvailabilityAlertSubscription $fosAvailabilityAlertSubscription
     * @param array $countOfSubscriberPerProductAbstract
     *
     * @return bool
     */
    protected function canSendNotification(
        FosAvailabilityAlertSubscription $fosAvailabilityAlertSubscription,
        $countOfSubscriberPerProductAbstract
    ) {
        $percentageDifference = $this->calculatePercentageDifference(
            $fosAvailabilityAlertSubscription,
            $countOfSubscriberPerProductAbstract
        );

        return $percentageDifference > $this->minimalPercentageDifference;
    }

    /**
     * @param \Orm\Zed\AvailabilityAlert\Persistence\FosAvailabilityAlertSubscription $fosAvailabilityAlertSubscription
     * @param array $countOfSubscriberPerProductAbstract
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
     * @param \Orm\Zed\AvailabilityAlert\Persistence\FosAvailabilityAlertSubscription $fosAvailabilityAlertSubscription
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
     * @return \Orm\Zed\AvailabilityAlert\Persistence\FosAvailabilityAlertSubscription[]|\Propel\Runtime\Collection\ObjectCollection
     */
    protected function getSubscritpions()
    {
        $idStore = $this->getIdStorebyStoreName(Store::getInstance()->getStoreName());

        return $this->queryContainer
            ->querySubscriptionsByIdStoreAndStatus($idStore, 0)
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

    /**
     * @param string $storeName
     *
     * @return int
     */
    protected function getIdStorebyStoreName(string $storeName): int
    {

        $storeEntity = SpyStoreQuery::create()
            ->filterByName($storeName)
            ->findOne();

        if ($storeEntity == null) {
            return 0;
        }
        
        return $storeEntity->getIdStore();
    }
}
