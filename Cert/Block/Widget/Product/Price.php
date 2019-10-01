<?php

namespace Jundat\Cert\Block\Widget\Product;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Price extends Template implements BlockInterface
{
    protected $_template = 'widget/product/price.phtml';

    protected $product;

    public function __construct(
        Template\Context $context,
        \Magento\Catalog\Model\Product $product,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->product = $product;
    }

    public function getProduct()
    {
        $productId = $this->getData('productId');
        return $this->product->load($productId);
    }

    public function getProductImages()
    {
        $product = $this->getProduct();
        $mediaGallery = $product->getMediaGalleryImages();
        $result = [];
        foreach ($mediaGallery as $item) {
            $result[] = $item->getData('url');
        }
        return $result;
    }

    public function getProductName()
    {
        $product = $this->getProduct();
        return $product->getName();
    }

    public function getProductDesc()
    {
        $product = $this->getProduct();
        return $product->getDescription();
    }

    public function renderProductPrice()
    {
        $product = $this->getProduct();
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

//    public function toHtml()
//    {
//        return $this->renderProductPrice();
//    }
}
