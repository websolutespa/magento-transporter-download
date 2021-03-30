<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See LICENSE and/or COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\TransporterDownload\Model\ResourceModel\Entity;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Websolute\TransporterDownload\Model\DownloadModel;
use Websolute\TransporterDownload\Model\ResourceModel\DownloadResourceModel;

class DownloadCollection extends AbstractCollection
{
    protected $_idFieldName = 'download_id';
    protected $_eventPrefix = 'transporter_download_collection';
    protected $_eventObject = 'download_collection';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(DownloadModel::class, DownloadResourceModel::class);
    }
}
