<?php

declare(strict_types=1);

namespace Esgi\Job\Api;

/**
 * Esgi job CRUD interface.
 * @api
 */
interface JobRepositoryInterface
{
    /**
     * Save block.
     *
     * @param \Esgi\Job\Api\Data\JobInterface $job
     * @return \Esgi\Job\Api\Data\JobInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\JobInterface $job);

    /**
     * Retrieve $job.
     *
     * @param int $jobId
     * @return \Esgi\Job\Api\Data\JobInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($jobId);

    /**
     * Retrieve jobs matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Esgi\Job\Api\Data\JobSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete job.
     *
     * @param \Esgi\Job\Api\Data\JobInterface $job
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\JobInterface $job);

    /**
     * Delete job by ID.
     *
     * @param int $jobId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($jobId);
}
