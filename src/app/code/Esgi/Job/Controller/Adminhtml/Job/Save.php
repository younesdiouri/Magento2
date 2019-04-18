<?php

namespace Esgi\Job\Controller\Adminhtml\Job;

use Magento\Backend\App\Action\Context;
use Esgi\Job\Model\Job;
use Esgi\Job\Model\JobFactory;
use Esgi\Job\Model\ResourceModel\Job as JobResourceModel;
use Esgi\Job\Api\JobRepositoryInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Esgi\Job\Controller\Adminhtml\Job
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;
    /**
     * Description $jobRepository field
     *
     * @var JobRepositoryInterface $jobRepository
     */
    protected $jobRepository;
    /**
     * Description $jobFactory field
     *
     * @var JobFactory $jobFactory
     */
    protected $jobFactory;
    /**
     * Description $jobResourceModel field
     *
     * @var JobResourceModel $jobResourceModel
     */
    protected $jobResourceModel;

    /**
     * Save constructor
     *
     * @param Context                       $context
     * @param \Magento\Framework\Registry   $coreRegistry
     * @param DataPersistorInterface        $dataPersistor
     * @param JobRepositoryInterface $jobRepository
     * @param JobFactory             $jobFactory
     * @param JobResourceModel       $jobResourceModel
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        JobRepositoryInterface $jobRepository,
        JobFactory $jobFactory,
        JobResourceModel $jobResourceModel
    ) {
        parent::__construct($context, $coreRegistry);

        $this->dataPersistor           = $dataPersistor;
        $this->jobRepository    = $jobRepository;
        $this->jobFactory       = $jobFactory;
        $this->jobResourceModel = $jobResourceModel;
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

            /** @var Job $model */
            $model = $this->jobFactory->create();

            $id = $this->getRequest()->getParam('entity_id');
            if ($id) {
                try {
                    $model = $this->jobRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This job no longer exists.'));

                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $this->jobRepository->save($model);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the job.'));
            }

            $this->dataPersistor->set('job_job', $data);

            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
