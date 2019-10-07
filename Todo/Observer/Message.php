<?php
/**
 * Created by PhpStorm.
 * User: tinhngo
 * Date: 03/10/2019
 * Time: 15:59
 */

namespace Jundat\Todo\Observer;


use Magento\Framework\Event\Observer;

class Message implements \Magento\Framework\Event\ObserverInterface
{

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/todo-message.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        $message = $observer->getData('message');

        $logger->info(print_r($message, true));
        $logger->info($observer->getEvent()->getName());
//        $logger->info(print_r($observer->getBlock()->getType(), true));
//        $logger->info($observer->getName());
    }
}