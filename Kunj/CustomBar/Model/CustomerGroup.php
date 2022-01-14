<?php

namespace BlueAcorn\CustomBar\Model;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Customer\Api\GroupRepositoryInterface;

class CustomerGroup
{
    /**
     * @var CustomerSession
     */
    protected $_customerSession;

    /**
     * Customer group repository
     *
     * @var GroupRepositoryInterface
     */
    protected $groupRepository;

    /**
     * @param CustomerSession $customerSession
     * @param GroupRepositoryInterface $groupRepository
     */
    public function __construct(
        CustomerSession $customerSession,
        GroupRepositoryInterface $groupRepository
    ) {
        $this->_customerSession = $customerSession;
        $this->groupRepository = $groupRepository;
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCustomerGroup()
    {
        $customerGroupId = 0;
        if( $this->_customerSession->isLoggedIn() ) {
            $customerGroupId = $this->_customerSession->getCustomer()->getGroupId();
        }
        return $this->groupRepository->getById($customerGroupId)->getCode();
    }
}
