<?php

namespace Esgi\Job\Controller\Adminhtml\Department;

use Magento\Backend\App\Action\Context;
use Esgi\Job\Model\Department;
use Esgi\Job\Model\DepartmentFactory;
use Esgi\Job\Model\ResourceModel\Department as DepartmentResourceModel;
use Esgi\Job\Api\DepartmentRepositoryInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Esgi\Job\Controller\Adminhtml\Department
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;
    /**
     * Description $departmentRepository field
     *
     * @var DepartmentRepositoryInterface $departmentRepository
     */
    protected $departmentRepository;
    /**
     * Description $departmentFactory field
     *
     * @var DepartmentFactory $departmentFactory
     */
    protected $departmentFactory;
    /**
     * Description $departmentResourceModel field
     *
     * @var DepartmentResourceModel $departmentResourceModel
     */
    protected $departmentResourceModel;

    /**
     * Save constructor
     *
     * @param Context                       $context
     * @param \Magento\Framework\Registry   $coreRegistry
     * @param DataPersistorInterface        $dataPersistor
     * @param DepartmentRepositoryInterface $departmentRepository
     * @param DepartmentFactory             $departmentFactory
     * @param DepartmentResourceModel       $departmentResourceModel
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        DepartmentRepositoryInterface $departmentRepository,
        DepartmentFactory $departmentFactory,
        DepartmentResourceModel $departmentResourceModel
    ) {
        parent::__construct($context, $coreRegistry);

        $this->dataPersistor           = $dataPersistor;
        $this->departmentRepository    = $departmentRepository;
        $this->departmentFactory       = $departmentFactory;
        $this->departmentResourceModel = $departmentResourceModel;
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

            /** @var Department $model */
            $model = $this->departmentFactory->create();

            $id = $this->getRequest()->getParam('entity_id');
            if ($id) {
                try {
                    $model = $this->departmentRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This department no longer exists.'));

                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $this->departmentRepository->save($model);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the department.'));
            }

            $this->dataPersistor->set('job_department', $data);

            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
