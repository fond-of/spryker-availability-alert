<?php

namespace FondOfSpryker\Zed\AvailabilityAlert\Business\Model;

use Generated\Shared\Transfer\AvailabilityAlertSubscriptionTransfer;
use FondOfSpryker\Zed\AvailabilityAlert\Persistence\AvailabilityAlertQueryContainerInterface;
use Orm\Zed\AvailabilityAlert\Persistence\FosAvailabilityAlertSubscription;
use Orm\Zed\AvailabilityAlert\Persistence\Map\FosAvailabilityAlertSubscriptionTableMap;

class SubscriptionManager implements SubscriptionManagerInterface
{
    /**
     * @var \FondOfSpryker\Zed\AvailabilityAlert\Persistence\AvailabilityAlertQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @param \FondOfSpryker\Zed\AvailabilityAlert\Persistence\AvailabilityAlertQueryContainerInterface $queryContainer
     */
    public function __construct(AvailabilityAlertQueryContainerInterface $queryContainer)
    {
        $this->queryContainer = $queryContainer;
    }

    /**
     * @param \Generated\Shared\Transfer\AvailabilityAlertSubscriptionTransfer $availabilityAlertSubscriptionTransfer
     *
     * @return bool
     */
    public function isAlreadySubscribed(
        AvailabilityAlertSubscriptionTransfer $availabilityAlertSubscriptionTransfer
    ) {
        $availabilityAlertSubscriptionTransfer->requireEmail();
        $availabilityAlertSubscriptionTransfer->requireFkProductAbstract();

        $subscriptionCount = $this->queryContainer
            ->querySubscriptionByEmailAndIdProductAbstractAndStatus(
                $availabilityAlertSubscriptionTransfer->getEmail(),
                $availabilityAlertSubscriptionTransfer->getFkProductAbstract(),
                FosAvailabilityAlertSubscriptionTableMap::COL_STATUS_PENDING
            )->count();

        return $subscriptionCount === 1;
    }


    /**
     * @param \Generated\Shared\Transfer\AvailabilityAlertSubscriptionTransfer $availabilityAlertSubscriptionTransfer
     *
     * @return void
     *
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function subscribe(
        AvailabilityAlertSubscriptionTransfer $availabilityAlertSubscriptionTransfer
    )
    {
        $availabilityAlertSubscriptionTransfer->requireEmail();
        $availabilityAlertSubscriptionTransfer->requireFkProductAbstract();
        $availabilityAlertSubscriptionTransfer->requireFkLocale();

        $availabilityAlertSubscriptionEntity = $this->queryContainer
            ->querySubscriptionByEmailAndIdProductAbstract(
                $availabilityAlertSubscriptionTransfer->getEmail(),
                $availabilityAlertSubscriptionTransfer->getFkProductAbstract()
            )->findOne();

        if ($availabilityAlertSubscriptionEntity === null) {
            $availabilityAlertSubscriptionEntity = new FosAvailabilityAlertSubscription();
            $availabilityAlertSubscriptionEntity->setEmail($availabilityAlertSubscriptionTransfer->getEmail())
                ->setFkProductAbstract($availabilityAlertSubscriptionTransfer->getFkProductAbstract());
        }

        $availabilityAlertSubscriptionEntity->setStatus(FosAvailabilityAlertSubscriptionTableMap::COL_STATUS_PENDING)
            ->setFkLocale($availabilityAlertSubscriptionTransfer->getFkLocale())
            ->setSentAt(null)
            ->save();
    }
}
