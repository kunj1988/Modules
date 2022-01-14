<?php

namespace BlueAcorn\CustomLog\Logger;

/**
 * Class Handler
 * @package BlueAcorn\CustomLog\Logger
 */
class Handler extends \Magento\Framework\Logger\Handler\Base
{
    /**
     * File name
     * @var string
     */
    protected $fileName = '/var/log/page-view.log';
}
