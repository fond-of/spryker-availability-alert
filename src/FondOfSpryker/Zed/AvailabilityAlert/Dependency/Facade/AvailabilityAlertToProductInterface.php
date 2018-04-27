<?php

namespace FondOfSpryker\Zed\AvailabilityAlert\Dependency\Facade;

use Generated\Shared\Transfer\ProductAbstractTransfer;

interface AvailabilityAlertToProductInterface
{
    /**
     * @see \Spryker\Zed\Product\Business\ProductFacadeInterface
     *
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer|null
     */
    public function findProductAbstractById($idProductAbstract);

    /**
     * @see \Spryker\Zed\Product\Business\ProductFacadeInterface
     *
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductUrlTransfer
     */
    public function getProductUrl(ProductAbstractTransfer $productAbstractTransfer);
}
