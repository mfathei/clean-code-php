<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use CleanPhp\Invoicer\Domain\Entity\Customer;
use CleanPhp\Invoicer\Domain\Repository\CustomerRepositoryInterface;
use CleanPhp\Invoicer\Service\InputFilter\CustomerInputFilter;
use Zend\Hydrator\HydratorInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CustomersController extends AbstractActionController
{
    protected $customerRepository;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        CustomerInputFilter $inputFilter,
        HydratorInterface $hydrator
    ) {
        $this->customerRepository = $customerRepository;
        $this->inputFilter        = $inputFilter;
        $this->hydrator           = $hydrator;
    }

    public function indexAction()
    {
        return [
            'customers' => $this->customerRepository->getAll(),
        ];
    }

    public function newAction()
    {
        $viewModel = new ViewModel();
        $customer = new Customer();

        if ($this->getRequest()->isPost()) {
            $this->inputFilter->setData($this->params()->fromPost());
            if ($this->inputFilter->isValid()) {
                $customer = $this->hydrator->hydrate(
                    $this->inputFilter->getValues(),
                    new Customer()
                );

                $this->customerRepository->begin()->persist($customer)->commit();
                $this->flashMessenger()->addSuccessMessage('Customer Saved!');
                $this->redirect()->toUrl('/customers');
            } else {
                $this->hydrator->hydrate(
                    $this->params()->fromPost(),
                    $customer
                );
                $viewModel->setVariable('errors', $this->inputFilter->getMessages());
            }
        }

        $viewModel->setVariable('customer', $customer);
        return $viewModel;
    }
}
