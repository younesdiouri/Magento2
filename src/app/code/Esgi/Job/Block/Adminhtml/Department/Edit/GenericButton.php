<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Esgi\Job\Block\Adminhtml\Department\Edit;

use Magento\Backend\Block\Widget\Context;
use Esgi\Job\Api\DepartmentRepositoryInterface;
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
     * @var DepartmentRepositoryInterface
     */
    protected $departmentRepository;

    /**
     * @param Context $context
     * @param DepartmentRepositoryInterface $departmentRepository
     */
    public function __construct(
        Context $context,
        DepartmentRepositoryInterface $departmentRepository
    ) {
        $this->context              = $context;
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * Return Job department ID
     *
     * @return int|null
     */
    public function getDepartmentId()
    {
        try {
            return $this->departmentRepository->getById(
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
