<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See LICENSE and/or COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\TransporterDownload\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface DownloadSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return DownloadInterface[]
     */
    public function getItems();

    /**
     * @param DownloadInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
