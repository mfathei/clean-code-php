<?php

use CleanPhp\Invoicer\Domain\Entity\Order;
use CleanPhp\Invoicer\Domain\Factory\InvoiceFactory;
use CleanPhp\Invoicer\Domain\Service\InvoicingService;
use CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface;

describe('InvoiceFactory', function () {
    describe('->createFromOrder', function () {
        it('should return an Invoice object', function () {
            $order = new Order();
            $invoiceFactory = new InvoiceFactory();
            $invoice = $invoiceFactory->createFromOrder($order);

            expect($invoice)->to->be->instanceof(
                'CleanPhp\Invoicer\Domain\Entity\Invoice'
            );
        });

        it('should send the total to the Invoice', function () {
            $order = new Order();
            $order->setTotal(500);

            $factory = new InvoiceFactory();
            $invoice = $factory->createFromOrder($order);

            expect($invoice->getTotal())->to->equal(500);
        });

        it('should associate the Order to the Invoice', function () {
            $order = new Order();
            $order->setTotal(500);

            $factory = new InvoiceFactory();
            $invoice = $factory->createFromOrder($order);

            expect($invoice->getOrder())->to->equal($order);
        });

        it('should set the date of the Invoice', function () {
            $order = new Order();
            $order->setTotal(500);

            $factory = new InvoiceFactory();
            $invoice = $factory->createFromOrder($order);

            // expect($invoice->getInvoiceDate())->to->loosely->equal(new \DateTime());
            expect($invoice->getInvoiceDate())->to->be->instanceof('DateTime');
        });
    });
});

describe('InvoicingService', function () {
    beforeEach(function () {
        $repo = 'CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface';
        $this->repository = $this->getProphet()->prophesize($repo);
    });

    afterEach(function () {
        $this->getProphet()->checkPredictions();
    });

    it('should query repository for uninvoiced Orders', function () {
        $this->repository->getUninvoicedOrders()->shouldBeCalled();
        $service = new InvoicingService($this->repository->reveal());
        $service->generateInvoices();
    });

    it('should return an Invoice for each uninvoiced Order');
});
