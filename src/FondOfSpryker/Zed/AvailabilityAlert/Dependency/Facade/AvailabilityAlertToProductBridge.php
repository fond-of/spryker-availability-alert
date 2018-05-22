<?php

namespace FondOfSpryker\Zed\AvailabilityAlert\Dependency\Facade;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\Product\Business\ProductFacade;

class AvailabilityAlertToProductBridge implements AvailabilityAlertToProductInterface
{
    /**
     * @var \Spryker\Zed\Product\Business\ProductFacade
     */
    protected $productFacade;

    /**
     * AvailabilityAlertToProductBridge constructor.
     *
     * @param \Spryker\Zed\Product\Business\ProductFacade $productFacade
     */
    public function __construct(ProductFacade $productFacade)
    {
        $this->productFacade = $productFacade;
    }

    /**
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer|null
     */
    public function findProductAbstractById($idProductAbstract)
    {
        return $this->productFacade->findProductAbstractById($idProductAbstract);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductUrlTransfer
     */
    public function getProductUrl(ProductAbstractTransfer $productAbstractTransfer)
    {
        return $this->productFacade->getProductUrl($productAbstractTransfer);
    }
}
