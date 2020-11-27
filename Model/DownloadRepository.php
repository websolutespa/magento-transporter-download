<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\TransporterDownload\Model;

use Exception;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use Websolute\TransporterDownload\Api\Data\DownloadInterface;
use Websolute\TransporterDownload\Api\Data\DownloadSearchResultInterface;
use Websolute\TransporterDownload\Api\Data\DownloadSearchResultInterfaceFactory;
use Websolute\TransporterDownload\Api\DownloadRepositoryInterface;
use Websolute\TransporterDownload\Model\DownloadModelFactory as DownloadFactory;
use Websolute\TransporterDownload\Model\ResourceModel\Entity\DownloadCollectionFactory;
use Websolute\TransporterDownload\Model\ResourceModel\DownloadResourceModel;

class DownloadRepository implements DownloadRepositoryInterface
{
    /**
     * @var DownloadFactory
     */
    private $downloadFactory;

    /**
     * @var DownloadCollectionFactory
     */
    private $collectionFactory;

    /**
     * @var DownloadSearchResultInterfaceFactory
     */
    private $searchResultFactory;

    /**
     * @var DownloadResourceModel
     */
    private $downloadResourceModel;

    /**
     * @param DownloadModelFactory $downloadFactory
     * @param DownloadCollectionFactory $collectionFactory
     * @param DownloadSearchResultInterfaceFactory $downloadSearchResultInterfaceFactory
     * @param DownloadResourceModel $downloadResourceModel
     */
    public function __construct(
        DownloadFactory $downloadFactory,
        DownloadCollectionFactory $collectionFactory,
        DownloadSearchResultInterfaceFactory $downloadSearchResultInterfaceFactory,
        DownloadResourceModel $downloadResourceModel
    ) {
        $this->downloadFactory = $downloadFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultFactory = $downloadSearchResultInterfaceFactory;
        $this->downloadResourceModel = $downloadResourceModel;
    }

    /**
     * @param int $id
     * @return DownloadInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): DownloadInterface
    {
        $download = $this->downloadFactory->create();
        $this->downloadResourceModel->load($download, $id);
        if (!$download->getId()) {
            throw new NoSuchEntityException(__('Unable to find TransporterDownload with ID "%1"', $id));
        }
        return $download;
    }

    /**
     * @param DownloadInterface $download
     * @throws Exception
     */
    public function delete(DownloadInterface $download)
    {
        $this->downloadResourceModel->delete($download);
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return DownloadSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): DownloadSearchResultInterface
    {
        $collection = $this->collectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    /**
     * @param int $activityId
     * @param string $downloaderType
     * @param string $status
     * @throws AlreadyExistsException
     */
    public function createOrUpdate(int $activityId, string $downloaderType, string $status)
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(DownloadModel::ACTIVITY_ID, ['eq' => $activityId]);
        $collection->addFieldToFilter(DownloadModel::DOWNLOADER_TYPE, ['eq' => $downloaderType]);
        $collection->load();

        /** @var DownloadModel $download */
        if ($collection->count()) {
            $download = $collection->getFirstItem();
        } else {
            $download = $this->downloadFactory->create();
            $download->setActivityId($activityId);
            $download->setDownloaderType($downloaderType);
        }

        $download->setStatus($status);

        $this->save($download);
    }

    /**
     * @param DownloadInterface $download
     * @return DownloadInterface
     * @throws AlreadyExistsException
     */
    public function save(DownloadInterface $download)
    {
        $this->downloadResourceModel->save($download);
        return $download;
    }

    /**
     * @param int $activityId
     * @param string $downloaderType
     * @param string $status
     * @throws AlreadyExistsException
     * @throws NoSuchEntityException
     */
    public function update(int $activityId, string $downloaderType, string $status)
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(DownloadModel::ACTIVITY_ID, ['eq' => $activityId]);
        $collection->addFieldToFilter(DownloadModel::DOWNLOADER_TYPE, ['eq' => $downloaderType]);
        $collection->load();

        if (!$collection->count()) {
            throw new NoSuchEntityException(__(
                'Non existing download ~ activityId:%1 ~ downloaderType:%2',
                $activityId,
                $downloaderType
            ));
        }

        /** @var DownloadInterface $download */
        $download = $collection->getFirstItem();
        $download->setStatus($status);

        $this->save($download);
    }

    /**
     * @param int $activityId
     * @return DownloadInterface[]
     */
    public function getAllByActivityId(int $activityId): array
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(DownloadModel::ACTIVITY_ID, ['eq' => $activityId]);
        $collection->load();

        /** @var DownloadInterface[] $downloads */
        $downloads = $collection->getItems();

        return $downloads;
    }
}
