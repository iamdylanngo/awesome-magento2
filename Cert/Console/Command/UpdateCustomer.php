<?php

namespace Jundat\Cert\Console\Command;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCustomer extends Command
{
    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     */
    protected $customerRepository;

    /**
     * @var \Magento\Framework\App\State $state
     */
    protected $state;

    /**
     * @var \Magento\Customer\Api\Data\CustomerInterfaceFactory $customerInterfaceFactory
     */
    protected $customerInterfaceFactory;

    public function __construct(
        \Magento\Framework\App\State $state,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Customer\Api\Data\CustomerInterfaceFactory $customerInterfaceFactory
    ) {
        $this->customerRepository = $customerRepository;
        $this->state = $state;
        $this->customerInterfaceFactory = $customerInterfaceFactory;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('customer:user:create')
            ->setDescription('Create new customer');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $self = $this;
        $this->state->emulateAreaCode(
            \Magento\Framework\App\Area::AREA_FRONTEND,
            function () use ($self, $input, $output) {
                $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_WEBAPI_REST);
                $output->writeln('<info>Creating new user...</info>');

                $customer = $this->customerRepository->get('tinh.ngo@niteco.se');
                $output->writeln(print_r($customer->getEmail(), true));

                $customerModel = $this->customerInterfaceFactory->create();
                $customerModel->setEmail('tinh.ngo1@gmail.com');
                $customerModel->setFirstname('Tinh');
                $customerModel->setLastname('Ngo');
                $this->customerRepository->save($customerModel);
            }
        );

//        $this->updateCustomer($input, $output);
        return Cli::RETURN_SUCCESS;
    }

    protected function updateCustomer($input, $output)
    {
        $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_WEBAPI_REST);
        $output->writeln('<info>Creating new user...</info>');

        $customer = $this->customerRepository->get('tinh.ngo@niteco.se');
        $output->writeln(print_r($customer->getEmail(), true));

        $customerModel = $this->customerInterfaceFactory->create();
        $customerModel->setEmail('tinh.ngo1@gmail.com');
        $customerModel->setFirstname('Tinh');
        $customerModel->setLastname('Ngo');
        $this->customerRepository->save($customerModel);
    }
}
