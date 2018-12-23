<?php

use CleanPhp\Invoicer\Domain\Entity\Invoice;
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
        $this->repository = $this->getProphet()->prophesize(CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface::class);
        $this->factory = $this->getProphet()->prophesize(CleanPhp\Invoicer\Domain\Factory\InvoiceFactory::class);
    });

    afterEach(function () {
        $this->getProphet()->checkPredictions();
    });

    it('should query repository for uninvoiced Orders', function () {
        $this->repository->getUninvoicedOrders()->willReturn([]);
        $this->repository->getUninvoicedOrders()->shouldBeCalled();
        $service = new InvoicingService($this->repository->reveal(), $this->factory->reveal());
        $service->generateInvoices();
    });

    it('should return an Invoice for each uninvoiced Order', function () {
        $orders = [(new Order())->setTotal(400)];
        $invoices = [(new Invoice())->setTotal(400)];

        $this->repository->getUninvoicedOrders()->willReturn($orders);
        $this->factory->createFromOrder($orders[0])->willReturn($invoices[0]);

        $service = new InvoicingService($this->repository->reveal(), $this->factory->reveal());
        $results = $service->generateInvoices();

        expect($results)->to->be->a('array');
        expect($results)->to->have->length(count($orders));
    });
});
