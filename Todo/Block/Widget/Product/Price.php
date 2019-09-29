<?php

namespace Jundat\Todo\Block\Widget\Product;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Price extends Template implements BlockInterface
{
    protected $_template = 'widget/product/price.phtml';
}
