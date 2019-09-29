<?php

namespace Jundat\Todo\Block;

use Jundat\Todo\Model\ResourceModel\Todo\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Symfony\Component\Process\PhpExecutableFinder;

class Index extends \Magento\Framework\View\Element\Template
{
    protected $collectionFactory;

    /**
     * The executable finder specifically designed for the PHP executable
     *
     * @var PhpExecutableFinder $phpExecutableFinder
     */
    private $phpExecutableFinder;

    /**
     * @var \Magento\Framework\App\Shell $shell
     */
    private $shell;

    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        PhpExecutableFinder $phpExecutableFinder,
        \Magento\Framework\App\Shell $shell,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
        $this->phpExecutableFinder = $phpExecutableFinder;
        $this->shell = $shell;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->getUrl('todo');
    }

    public function getAllTodo()
    {
        return $this->collectionFactory->create()->getItems();
    }

    /**
     * Runs consumers processes
     */
    public function run()
    {
        $php = $this->phpExecutableFinder->find() ?: 'php';

        $consumerName = 'jundat.todo.customer';

        $arguments = [];

        $command = $php . ' ' . BP . '/bin/magento queue:consumers:start ' . $consumerName;

        $this->shell->execute($command, $arguments);
    }
}
