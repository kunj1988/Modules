<?php

namespace BlueAcorn\OrderCount\Helper;

use Magento\Sales\Model\Order;
use Magento\Sales\Model\ResourceModel\Sale\Collection;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Helper\Context;
use Magento\Sales\Model\OrderFactory;

/**
 * Class Data
 * @package BlueAcorn\OrderCount\Helper
 *
 */
class Data extends AbstractHelper
{
    /**
     * @var Session
     */
    private $_session;
    /**
     * @var OrderFactory
     */
    private $_orderFactory;

    /**
     * Data constructor.
     *
     * @param Context $context
     * @param Session $session
     * @param OrderFactory $orderFactory
     */
    public function __construct(
        Context $context,
        Session $session,
        OrderFactory $orderFactory
    ) {
        $this->_session = $session;
        $this->_orderFactory = $orderFactory;
        parent::__construct($context);
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        $count = $this->getOrders()->count();
        return "My Order(".$count.")";
    }

    /**
     * @return Collection
     */
    public function getOrders()
    {
        $customerId = $this->_session->getCustomer()->getId();
        /** @var Order $order */
        $order = $this->_orderFactory->create();
        /** @var Collection $orderCollection */
        $orderCollection = $order->getCollection()->addFieldToSelect(
            '*'
        )->addFieldToFilter(
            'customer_id',
            $customerId
        )->setOrder(
            'created_at',
            'desc'
        );
        return $orderCollection;
    }
}
