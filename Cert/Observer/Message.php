<?php

namespace Jundat\Cert\Observer;


use Magento\Framework\Event\Observer;

class Message implements \Magento\Framework\Event\ObserverInterface
{

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/cert-message.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        $message = $observer->getData('message');

        $logger->info(print_r($message, true));
    }
}