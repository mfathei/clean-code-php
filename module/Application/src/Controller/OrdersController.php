<?php

namespace Application\Controller;

use CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface;
use Zend\Mvc\Controller\AbstractActionController;

class OrdersController extends AbstractActionController
{
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function indexAction()
    {
        return [
            'orders' => $this->orderRepository->getAll(),
        ];
    }
}
