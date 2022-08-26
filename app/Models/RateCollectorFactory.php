<?php
/**
 * @author Aleksey Fiodorov
 * @copyright Copyright (c) saint-father (https://github.com/saint-father)
 */

namespace App\Models;

use App\Models\Helper\Data as DataHelper;

class RateCollectorFactory
{
    /**
     * @var RateCollector
     */
    private RateCollector $rateCollector;

    /**
     * @param RateCollector $rateCollector
     */
    public function __construct(
        RateCollector $rateCollector
    ) {
        $this->rateCollector = $rateCollector;
    }

    /**
     * Return Collector object as result of Factory generation (seems useless now)
     *
     * @param DataHelper $dataHelper
     * @return RateCollector
     * @throws \App\Exceptions\TickerException
     */
    public function getCollector(DataHelper $dataHelper) : RateCollector
    {
        // will be required for multicurrency exchange
        return $this->rateCollector->init($dataHelper->getCurrency());
    }
}
