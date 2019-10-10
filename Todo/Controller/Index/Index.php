<?php

namespace Jundat\Todo\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    protected $todoFactory;

    protected $todo;

    protected $collectionFactory;

    public function __construct(
        Context $context,
        \Jundat\Todo\Model\TodoFactory $todoFactory,
        \Jundat\Todo\Model\Todo $todo,
        \Jundat\Todo\Model\ResourceModel\Todo\CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->todoFactory = $todoFactory;
        $this->todo = $todo;
        $this->collectionFactory = $collectionFactory;
    }

    public function getByCollection()
    {
        $temp = $this->collectionFactory->create();
        $temp1 = $temp->getMainTable();
    }

    public function getByModel()
    {
        $temp = $this->todo->load(1)->getData();
        $temp2 = $this->todo->getCollection();
        $temp1 = 3;
    }

    public function addByFactory($title, $description)
    {
        $todo = $this->todoFactory->create();
        $todo->setData('title', $title);
        $todo->setData('description', $description);
        try {
            $todo->save();
        } catch (\Exception $e) {
            var_dump($e);
            die($e);
        }
    }

    public function getByFactory()
    {
        $todo = $this->todoFactory->create();
        $todos = $todo->getCollection();

        $todos
            ->addFieldToFilter('id', ['gt' => 5]);
        $response = "";
        foreach ($todos as $item) {
            $response .= $item->getData('title') . '--';
        }
        return $response;
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return string
     */
    public function execute()
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        $title = $this->getRequest()->getParam('title') ?? "";
        $description = $this->getRequest()->getParam('description') ?? "";
        $file = $this->getRequest()->getParams('link');
        $fileName = basename($file['link']);

        $logger->info(print_r($file, true));
        $logger->info(print_r($fileName, true));

        $payload = new \Magento\Framework\DataObject(['name' => $title]);
        $this->_eventManager->dispatch('cert_event_message', ['message' => $payload]);

        $this->_eventManager->dispatch('cert_event_message1', ['message' => $payload]);

        if (!empty($title) && !empty($description)) {
            $this->addByFactory($title, $description);
            $this->_redirect('todo');
        }

        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
