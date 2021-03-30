<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See LICENSE and/or COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\TransporterDownload\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Websolute\TransporterDownload\Api\Data\DownloadInterface;
use Websolute\TransporterDownload\Api\Data\DownloadSearchResultInterface;

interface DownloadRepositoryInterface
{
    /**
     * @param int $id
     * @return DownloadInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): DownloadInterface;

    /**
     * @param DownloadInterface $download
     * @return DownloadInterface
     */
    public function save(DownloadInterface $download);

    /**
     * @param DownloadInterface $download
     * @return void
     */
    public function delete(DownloadInterface $download);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return DownloadSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): DownloadSearchResultInterface;

    /**
     * @param int $activityId
     * @param string $downloaderType
     * @param string $status
     */
    public function createOrUpdate(int $activityId, string $downloaderType, string $status);

    /**
     * @param int $activityId
     * @param string $downloaderType
     * @param string $status
     */
    public function update(int $activityId, string $downloaderType, string $status);

    /**
     * @param int $activityId
     * @return DownloadInterface[]
     */
    public function getAllByActivityId(int $activityId): array;
}
