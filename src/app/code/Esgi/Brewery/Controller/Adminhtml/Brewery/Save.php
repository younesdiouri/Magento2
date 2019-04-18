<?php

namespace Esgi\Brewery\Controller\Adminhtml\Brewery;

use Magento\Backend\App\Action\Context;
use Esgi\Brewery\Model\Brewery;
use Esgi\Brewery\Model\BreweryFactory;
use Esgi\Brewery\Model\ResourceModel\Brewery as BreweryResourceModel;
use Esgi\Brewery\Api\BreweryRepositoryInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Esgi\Brewery\Controller\Adminhtml\Brewery
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;
    /**
     * Description $breweryRepository field
     *
     * @var BreweryRepositoryInterface $breweryRepository
     */
    protected $breweryRepository;
    /**
     * Description $breweryFactory field
     *
     * @var BreweryFactory $breweryFactory
     */
    protected $breweryFactory;
    /**
     * Description $breweryResourceModel field
     *
     * @var BreweryResourceModel $breweryResourceModel
     */
    protected $breweryResourceModel;

    /**
     * Save constructor
     *
     * @param Context                       $context
     * @param \Magento\Framework\Registry   $coreRegistry
     * @param DataPersistorInterface        $dataPersistor
     * @param BreweryRepositoryInterface $breweryRepository
     * @param BreweryFactory             $breweryFactory
     * @param BreweryResourceModel       $breweryResourceModel
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        BreweryRepositoryInterface $breweryRepository,
        BreweryFactory $breweryFactory,
        BreweryResourceModel $breweryResourceModel
    ) {
        parent::__construct($context, $coreRegistry);

        $this->dataPersistor           = $dataPersistor;
        $this->breweryRepository    = $breweryRepository;
        $this->breweryFactory       = $breweryFactory;
        $this->breweryResourceModel = $breweryResourceModel;
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data           = $this->getRequest()->getPostValue();
        if ($data) {
            if (empty($data['entity_id'])) {
                $data['entity_id'] = null;
            }

            /** @var Brewery $model */
            $model = $this->breweryFactory->create();

            $id = $this->getRequest()->getParam('entity_id');
            if ($id) {
                try {
                    $model = $this->breweryRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This brewery no longer exists.'));

                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $this->breweryRepository->save($model);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the brewery.'));
            }

            $this->dataPersistor->set('brewery_brewery', $data);

            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
