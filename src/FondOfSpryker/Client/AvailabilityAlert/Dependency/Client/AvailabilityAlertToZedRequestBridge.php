<?php

namespace FondOfSpryker\Client\AvailabilityAlert\Dependency\Client;

use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;
use Spryker\Shared\Kernel\Transfer\TransferInterface;

class AvailabilityAlertToZedRequestBridge implements AvailabilityAlertToZedRequestInterface
{
    /**
     * @var \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected $zedRequestClient;

    /**
     * AvailabilityAlertToZedRequestBridge constructor.
     * @param  \Spryker\Client\ZedRequest\ZedRequestClientInterface  $zedRequestClient
     */
    public function __construct(ZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param string $url
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $object
     * @param int|null $timeoutInSeconds
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    public function call(string $url, TransferInterface $object, ?int $timeoutInSeconds = null): TransferInterface
    {
        return $this->zedRequestClient->call($url, $object, $timeoutInSeconds);
    }
}
