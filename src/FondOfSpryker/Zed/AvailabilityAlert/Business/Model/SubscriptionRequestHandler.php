<?php

namespace FondOfSpryker\Zed\AvailabilityAlert\Business\Model;

use Generated\Shared\Transfer\AvailabilityAlertSubscriptionTransfer;
use Generated\Shared\Transfer\AvailabilityAlertSubscriptionResponseTransfer;
use Generated\Shared\Transfer\AvailabilityAlertSubscriptionErrorTransfer;

class SubscriptionRequestHandler implements SubscriptionRequestHandlerInterface
{
    /**
     * @var \FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscriptionManagerInterface
     */
    protected $subscriptionManager;


    /**
     * @param \FondOfSpryker\Zed\AvailabilityAlert\Business\Model\SubscriptionManagerInterface $subscriptionManager
     */
    public function __construct(
        SubscriptionManagerInterface $subscriptionManager
    ) {
        $this->subscriptionManager = $subscriptionManager;
    }

    /**
     * @param \Generated\Shared\Transfer\AvailabilityAlertSubscriptionTransfer $availabilityAlertSubscriptionTransfer
     *
     * @return \Generated\Shared\Transfer\AvailabilityAlertSubscriptionResponseTransfer
     */
    public function processAvailabilityAlertSubscription(
        AvailabilityAlertSubscriptionTransfer $availabilityAlertSubscriptionTransfer
    ) {
        $subscriptionResponse = $this->createSubscriptionResponse();

        $subscriptionResponse->setIsSuccess(true);

        try {
            if (!$this->subscriptionManager->isAlreadySubscribed($availabilityAlertSubscriptionTransfer)) {
                $this->subscriptionManager->subscribe($availabilityAlertSubscriptionTransfer);
            }
        } catch (\Exception $e) {
            $subscriptionError = $this->createSubscriptionError();

            $subscriptionError->setMessage($e->getMessage());

            $subscriptionResponse->setIsSuccess(false)
                ->addError($subscriptionError);
        }

        return $subscriptionResponse;

    }

    /**
     * @return \Generated\Shared\Transfer\AvailabilityAlertSubscriptionResponseTransfer
     */
    protected function createSubscriptionResponse()
    {
        return new AvailabilityAlertSubscriptionResponseTransfer();
    }

    /**
     * @return \Generated\Shared\Transfer\AvailabilityAlertSubscriptionErrorTransfer
     */
    protected function createSubscriptionError()
    {
        return new AvailabilityAlertSubscriptionErrorTransfer();
    }
}
