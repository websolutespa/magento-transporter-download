<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See LICENSE and/or COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\TransporterDownload\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class DownloadResourceModel extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('transporter_download', 'download_id');
    }
}
