<?php

namespace DaanBeverdam\CheckoutBlockProvider\Model;


use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\View\LayoutInterface;

class ConfigProvider implements ConfigProviderInterface
{
    /** @var LayoutInterface  */
    protected $_layout;
    protected $blocks;

    public function __construct(LayoutInterface $layout, $blockIds)
    {
        $this->_layout = $layout;
    }

    public function getConfig()
    {
        //$myBlockId = "my_static_block"; // CMS Block Identifier
        $myBlockId = 1;

        return [
            'my_block_content' => $this->_layout->createBlock('Magento\Cms\Block\Block')->setBlockId($myBlockId)->toHtml()
        ];
    }
}