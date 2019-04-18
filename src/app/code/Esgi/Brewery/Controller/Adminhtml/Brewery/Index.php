<?php
namespace Esgi\Brewery\Controller\Adminhtml\Brewery;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

class Index extends Action
{
    const ADMIN_RESOURCE = 'Esgi_Brewery::brewery';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Esgi_Brewery::brewery');
        $resultPage->addBreadcrumb(__('Breweries'), __('Breweries'));
        $resultPage->addBreadcrumb(__('Manage Breweries'), __('Manage Breweries'));
        $resultPage->getConfig()->getTitle()->prepend(__('Brewery'));

        return $resultPage;
    }
}
