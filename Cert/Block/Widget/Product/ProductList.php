<?php

namespace Jundat\Cert\Block\Widget\Product;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class ProductList extends Template implements BlockInterface
{
    protected $_template = 'widget/product/product-list.phtml';

    protected $collection;

    public function __construct(
        Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collection,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collection = $collection;
    }

    public function getProducts()
    {
        $before = microtime(true);
        $products = $this->collection->create()->addFieldToFilter('entity_id', ['in' => range(1, 5, 1)])->addAttributeToSelect(['name', 'url']);
        foreach ($products as $product) {
            /**
             * @var \Magento\Catalog\Model\Product $product
             */
            $sku = $product->getSku();
            $description  = $product->getDescription();
            $images = $product->getMediaGalleryImages();
            $thumbnail = $product->getThumbnail();
            $price = $this->renderProductPrice($product);
        }
        $after = microtime(true);
        var_dump($after - $before);
        die();
    }

    public function renderProductPrice($product)
    {
        /** @var \Magento\Framework\Pricing\Render $priceRender */
        $priceRender = $this->getLayout()->getBlock('product.price.render.default');

        $price = '';
        if ($priceRender) {
            $price = $priceRender->render(
                \Magento\Catalog\Pricing\Price\FinalPrice::PRICE_CODE,
                $product
            );
        }
        return $price;
    }

    public function getBlockHtml($name)
    {
        return parent::getBlockHtml($name);
    }
}
