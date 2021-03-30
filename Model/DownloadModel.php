<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See LICENSE and/or COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\TransporterDownload\Model;

use DateTime;
use Exception;
use Magento\Framework\DataObject;
use Magento\Framework\Model\AbstractExtensibleModel;
use Websolute\TransporterDownload\Api\Data\DownloadInterface;

class DownloadModel extends AbstractExtensibleModel implements DownloadInterface
{
    const ID = 'download_id';
    const ACTIVITY_ID = 'activity_id';
    const DOWNLOADER_TYPE = 'downloader_type';
    const STATUS = 'status';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const CACHE_TAG = 'transporter_download';
    protected $_cacheTag = 'transporter_download';
    protected $_eventPrefix = 'transporter_download';

    /**
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return int
     */
    public function getActivityId(): int
    {
        return (int)$this->getData(self::ACTIVITY_ID);
    }

    /**
     * @param int $activityId
     * @return void
     */
    public function setActivityId(int $activityId)
    {
        $this->setData(self::ACTIVITY_ID, $activityId);
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return (string)$this->getData(self::STATUS);
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->setData(self::STATUS, $status);
    }

    /**
     * @return string
     */
    public function getDownloaderType(): string
    {
        return (string)$this->getData(self::DOWNLOADER_TYPE);
    }

    /**
     * @param string $downloaderType
     */
    public function setDownloaderType(string $downloaderType)
    {
        $this->setData(self::DOWNLOADER_TYPE, $downloaderType);
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->getData(self::CREATED_AT));
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getUpdatedAt(): DateTime
    {
        return new DateTime($this->getData(self::UPDATED_AT));
    }

    protected function _construct()
    {
        $this->_init(ResourceModel\DownloadResourceModel::class);
    }
}
