<?php

namespace Esgi\Brewery\Controller\Adminhtml\Brewery;

class Edit extends \Esgi\Brewery\Controller\Adminhtml\Brewery
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context        $context
     * @param \Magento\Framework\Registry                $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit Brewery brewery
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id    = $this->getRequest()->getParam('id');
        $model = $this->_objectManager->create(\Esgi\Brewery\Model\Brewery::class);
        // TODO : inject repository in controller instead of using model for load
        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This brewery no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('brewery_brewery', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Brewery') : __('New Brewery'),
            $id ? __('Edit Brewery') : __('New Brewery')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Breweries'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getName() : __('New Brewery'));

        return $resultPage;
    }
}
