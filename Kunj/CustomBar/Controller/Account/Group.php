<?php

namespace BlueAcorn\CustomBar\Controller\Account;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use BlueAcorn\CustomBar\Model\CustomerGroup;

class Group extends Action
{
    /**
     * @var JsonFactory
     */
    protected $_resultJsonFactory;

    /**
     * @var CustomerGroup
     */
    protected $_customerGroup;

    /**
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param CustomerGroup $customerGroup
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        CustomerGroup $customerGroup
    ) {
        $this->_customerGroup = $customerGroup;
        $this->_resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $result = $this->_resultJsonFactory->create();
        $customerGroup = $this->_customerGroup->getCustomerGroup();
        $result->setData(['customer_group' => $customerGroup]);
        return $result;
    }
}
