<?php
/**
 * @author Aleksey Fiodorov
 * @copyright Copyright (c) saint-father (https://github.com/saint-father)
 */

namespace App\Models;

use App\Models\Helper\Data as DataHelper;

class BtnConverterFactory
{
    /**
     * @var BtnConverter
     */
    private BtnConverter $btnConverter;
    /**
     * @var DataHelper
     */
    private DataHelper $dataHelper;
    /**
     * @var
     */
    private $initialRate;

    /**
     * BtnConverterFactory constructor
     *
     * @param BtnConverter $btnConverter
     * @param DataHelper $dataHelper
     */
    public function __construct(
        BtnConverter $btnConverter,
        DataHelper $dataHelper
    ) {
        $this->btnConverter = $btnConverter;
        $this->dataHelper = $dataHelper;
    }

    /**
     * Initialize Converter object with rate accordingly with conversation method
     *
     * @param $type
     * @param RateCollector $rateCollector
     * @return BtnConverter
     */
    public function getConverter($type, RateCollector $rateCollector)
    {
        $rates = $rateCollector->getCurrencyRates();
        $this->initialRate = $rates[$type];

        if ($type == DataHelper::BUY_CONVERT_METHOD) {
            return $this->btnConverter->init(1/$this->initialRate);
        }

        return $this->btnConverter->init($this->initialRate);
    }

    /**
     * Get initialized rate value
     *
     * @return mixed
     */
    public function getInitialRate()
    {
        return $this->initialRate;
    }
}
