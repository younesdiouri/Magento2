<?php

namespace Esgi\Brewery\Plugin;

use Esgi\Brewery\Controller\Adminhtml\Brewery\Save;
use Magento\Framework\App\RequestInterface;

/**
 * Class BreweryProductsSave
 * @package Esgi\Brewery\Plugin
 */
class BreweryProductsSave
{
    /** @var RequestInterface $request */
    protected $request;

    /**
     * BreweryProductsSave constructor.
     * @param RequestInterface $request
     */
    public function __construct(
        RequestInterface $request
    ) {
       $this->request = $request;
    }

    public function aroundExecute(Save $subject, callable $proceed) {
        return $proceed();
    }
}
