<?php
/**
 * @author Aleksey Fiodorov
 * @copyright Copyright (c) saint-father (https://github.com/saint-father)
 */

namespace App\Models;

use App\Exceptions\TickerException;
use App\Models\Helper\Data as DataHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class RateCollector implements IRateCollector
{
    /**
     * @var DataHelper
     */
    private DataHelper $dataHelper;
    /**
     * @var Collection
     */
    private Collection $rateCollection;

    /**
     * Object initializer - receives and process BTC rates data
     *
     * @param $currency
     * @return $this
     * @throws TickerException
     */
    public function init($currency): self
    {
        $sorting = [];
        $commissionValue = 1-(DataHelper::COMMISSION_PERCENT/100);
        $url = DataHelper::BLOCKCHAIN_INFO_TICKER_URL;
        $exchange = json_decode(file_get_contents($url), true);

        if (empty($exchange)) {
            throw new TickerException('Empty third service response', JsonResponse::HTTP_BAD_GATEWAY);
        }

        if (!empty($currency) && array_key_exists($currency, $exchange)) {
            $exchange = [$currency => $exchange[$currency]];
        } else {
            foreach ($exchange as $key => $row) {
                $sorting[$key] = $row[DataHelper::SORT_KEY];
            }
            array_multisort($sorting, SORT_ASC, $exchange);
        }

        // Laravel collections are "macroable"
        Collection::macro('addCommission', function ($requiredItems, $commission) {
            return $this->mapWithKeys(function ($item, $key) use ($requiredItems, $commission) {
                return [
                    $key => array_map(
                        fn($value): float => round($value / $commission, 2),
                        // "buy" and "sell" fields are required only
                        Arr::only($item, $requiredItems)
                    )
                ];
            });
        });

        $this->rateCollection = collect($exchange)->addCommission(DataHelper::REQUIRED_FIELDS, $commissionValue);

        return $this;
    }

    /**
     * Get collection with processed rates
     *
     * @return Collection
     */
    public function getRateCollection() : Collection
    {
        return $this->rateCollection;
    }

    /**
     * Get sell and buy rates for current or first currency
     *
     * @param string|null $currency
     * @return array
     */
    public function getCurrencyRates(?string $currency = '') : array
    {
        if (!empty($currency)) {
            return $this->getRateCollection()->get($currency);
        }

        return $this->getRateCollection()->pop();
    }
}
