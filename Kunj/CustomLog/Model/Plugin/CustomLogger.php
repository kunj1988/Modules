<?php

namespace BlueAcorn\CustomLog\Model\Plugin;


use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\HTTP\PhpEnvironment\Response;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Page\Title;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use BlueAcorn\CustomLog\Logger\Logger;

/**
 * Class CustomLogger
 * @package BlueAcorn\CustomLog\Model\Plugin
 */
class CustomLogger
{
    /**
     * Logging instance
     * @var Logger
     */
    private $_logger;

    /**
     * @var State
     */
    private $state;

    /**
     * @var Title
     */
    private $pageTitle;

    /**
     * @var RemoteAddress
     */
    private $remoteAddress;

    /**
     * @var UrlInterface
     */
    private $urlInterface;

    /**
     * CustomLogger constructor.
     * @param Logger $logger
     * @param State $state
     * @param Title $pageTitle
     * @param RemoteAddress $remoteAddress
     * @param UrlInterface $urlInterface
     */
    public function __construct(
        Logger $logger,
        State $state,
        Title $pageTitle,
        RemoteAddress $remoteAddress,
        UrlInterface $urlInterface
    ) {
        $this->urlInterface = $urlInterface;
        $this->remoteAddress = $remoteAddress;
        $this->pageTitle = $pageTitle;
        $this->state = $state;
        $this->_logger = $logger;
    }

    /**
     * Refresh the customer session on frontend post requests if an update session notification is registered.
     *
     * @param ActionInterface $subject
     * @param ResultInterface|Response|null $result
     * @return ResultInterface|Response|null
     * @throws \Magento\Framework\Exception\LocalizedException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterExecute(ActionInterface $subject, $result)
    {
        if ($this->isFrontendRequest()) {
            $this->_logger->debug($this->getPageViewerData($result));
        }
        return $result;
    }
    public function getPageViewerData($result)
    {
        $pageTitle = $this->pageTitle->getShort();

            if ($result instanceof \Magento\Framework\View\Result\Page) {
                $pageTitle = ($pageTitle == "")?$result->getConfig()->getTitle()->getShort():$pageTitle;
            }
        $ipAddress = $this->remoteAddress->getRemoteAddress(false);
        $currentUrl = $this->urlInterface->getCurrentUrl();
        return $pageTitle.": ".$currentUrl." - ".$ipAddress;
    }

    /**
     * Check if the current application area is frontend.
     *
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function isFrontendRequest(): bool
    {
        return $this->state->getAreaCode() === Area::AREA_FRONTEND;
    }
}
