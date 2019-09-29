<?php

namespace Jundat\Queue\Model\Product;

class SpecialPriceHandler
{
    protected $date;

    private $errors;

    /**
     * @var \Magento\Catalog\Model\Product\Action $productAction
     */
    protected $productAction;

    /**
     * @var \Magento\Catalog\Model\ProductRepository $productRepository
     */
    protected $productRepository;


    public function __construct(
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime,
        \Magento\Catalog\Model\Product\Action $productAction,
        \Magento\Catalog\Model\ProductRepository $productRepository
    ) {
        $this->date = $dateTime;
        $this->productAction = $productAction;
        $this->productRepository = $productRepository;
    }

    /**
     * processMessage
     *
     * @param \Jundat\Queue\Api\Data\SpecialPriceInterface[] $specialPrices
     * @return void
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function processMessage(
        array $specialPrices
    ) {
        $this->updateSpecialPrice($specialPrices);
    }

    /***
     * @param $prices
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function updateSpecialPrice($prices)
    {
        /**
         * @var \Jundat\Queue\Api\Data\SpecialPriceInterface $price
         */
        foreach ($prices as $price) {
            $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/demo111.log');
            $logger = new \Zend\Log\Logger();
            $logger->addWriter($writer);
            $logger->info('product info12: ');
            $logger->info($price->getSku());
            $logger->info($price->getPrice());
            $logger->info($price->getStoreId());

            $specialPrice = $price->getPrice();
            $sku = $price->getSku();
            $storeId = $price->getStoreId();
            $priceFrom = $price->getPriceFrom();
            $priceTo = $price->getPriceTo();

            // Validate params
            if (is_null($sku)) {
                $this->errors = "SKU: " . $sku . " wrong sku, ";
                return;
            }

            if (is_null($specialPrice) || !is_numeric($specialPrice)) {
                $this->errors = "SKU: " . $sku . " wrong price, ";
                return;
            }

            if (is_null($storeId) || !is_numeric($storeId)) {
                $this->errors = "SKU: " . $sku . " wrong store_id, ";
                return;
            }

            if (!is_null($priceFrom)) {
                if (!$this->isCorrectDateValue($priceFrom)) {
                    $this->errors = "SKU: " . $sku . " wrong price_from, ";
                    return;
                }
            }

            if (!is_null($priceTo)) {
                if (!$this->isCorrectDateValue($priceTo)) {
                    $this->errors = "SKU: " . $sku . " wrong price_to, ";
                    return;
                }
            }

            $product = $this->productRepository->get($sku);
            $productId = $product->getEntityId();

            $priceFrom = date("Y-m-d H:i:s", strtotime($priceFrom));
            if (is_null($priceFrom) || empty($priceFrom)) {
                $priceFrom = $this->dateTime->gmtDate();
            }

            $priceTo = date("Y-m-d H:i:s", strtotime($priceTo));
            if (is_null($priceTo) || empty($priceTo)) {
                $priceTo = date("Y-m-d H:i:s", strtotime("9999-01-01"));
            }

            $attributeValue = [];
            if ($specialPrice <= -1) {
                $attributeValue['special_price'] = null;
                $attributeValue['special_from_date'] = null;
                $attributeValue['special_to_date'] = null;
            } else {
                $attributeValue['special_price'] = $specialPrice;
                $attributeValue['special_from_date'] = $priceFrom;
                $attributeValue['special_to_date'] = $priceTo;
            }
            $this->productAction->updateAttributes([$productId], $attributeValue, $storeId);
            $logger->info('product end');
        }
    }

    /**
     * Check that date value is correct.
     *
     * @param string $date
     * @return bool
     */
    private function isCorrectDateValue($date)
    {
        $actualDate = date('Y-m-d H:i:s', strtotime($date));
        return $actualDate && $actualDate === $date;
    }
}
