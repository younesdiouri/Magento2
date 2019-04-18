<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Esgi\Job\Block\Adminhtml\Job\Edit;

use Magento\Backend\Block\Widget\Context;
use Esgi\Job\Api\JobRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var JobRepositoryInterface
     */
    protected $jobRepository;

    /**
     * @param Context $context
     * @param JobRepositoryInterface $jobRepository
     */
    public function __construct(
        Context $context,
        JobRepositoryInterface $jobRepository
    ) {
        $this->context              = $context;
        $this->jobRepository = $jobRepository;
    }

    /**
     * Return Job job ID
     *
     * @return int|null
     */
    public function getJobId()
    {
        try {
            return $this->jobRepository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
