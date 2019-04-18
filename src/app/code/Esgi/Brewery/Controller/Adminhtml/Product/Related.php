<?php

namespace Esgi\Brewery\Controller\Adminhtml\Product;

class Related extends \Magento\Catalog\Controller\Adminhtml\Product\Related
{
    /**
     * @return \Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $this->productBuilder->build($this->getRequest());
        $resultLayout = $this->resultLayoutFactory->create();
        $resultLayout->getLayout()->getBlock('brewery_edit_tab_related')
            ->setProductsRelated($this->getRequest()->getPost('products_related', null));

        return $resultLayout;
    }
}
