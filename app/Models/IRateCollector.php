<?php
/**
 * @author Aleksey Fiodorov
 * @copyright Copyright (c) saint-father (https://github.com/saint-father)
 */

namespace App\Models;

use App\Models\Helper\Data as DataHelper;
use Illuminate\Support\Collection;

interface IRateCollector
{
    /**
     * @param DataHelper $dataHelper
     * @return $this
     */
    public function init(DataHelper $dataHelper) : self;

    /**
     * @return Collection
     */
    public function getRateCollection() : Collection;

    /**
     * @param string|null $currency
     * @return array
     */
    public function getCurrencyRates(?string $currency) : array;
}
