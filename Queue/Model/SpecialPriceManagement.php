<?php

namespace Jundat\Queue\Model;

use Jundat\Queue\Api\SpecialPriceInterface;
use Magento\Framework\MessageQueue\PublisherInterface;
use Magento\Framework\Json\Helper\Data as JsonHelper;

class SpecialPriceManagement implements SpecialPriceInterface
{

    const TOPIC_NAME = 'async.product.special.price';

    protected $messagePublisher;

    protected $specialPriceResultInterfaceFactory;


    public function __construct(
        PublisherInterface $publisher,
        \Jundat\Queue\Api\Data\SpecialPriceResultInterfaceFactory $specialPriceResultInterfaceFactory
    ) {
        $this->specialPriceResultInterfaceFactory = $specialPriceResultInterfaceFactory;
        $this->messagePublisher = $publisher;
    }

    /**
     * {@inheritdoc}
     */
    public function setSpecialPrice(array $prices)
    {

        $this->messagePublisher->publish(self::TOPIC_NAME, $prices);

        $result = $this->specialPriceResultInterfaceFactory->create();
        $result->setMessage("set special prices is successfully.");
        $response[] = $result;
        return $response;
    }
}
