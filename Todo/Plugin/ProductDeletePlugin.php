<?php

namespace Jundat\Todo\Plugin;

use Jundat\Todo\Model\DeletePublisher;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\ResourceModel\Product;
use Magento\Quote\Model\Product\QuoteItemsCleanerInterface;

class ProductDeletePlugin
{
    /**
     * @var QuoteItemsCleanerInterface
     */
    private $productDeletePublisher;

    /**
     * @param DeletePublisher $productDeletePublisher
     */
    public function __construct(DeletePublisher $productDeletePublisher)
    {
        $this->productDeletePublisher = $productDeletePublisher;
    }

    /**
     * @param Product $product
     * @param ProductResource $result
     * @return ProductResource
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterDelete(
        Product $product,
        $result
    ) {
        $this->productDeletePublisher->execute($product);
        return $result;
    }
}
