<?php
/**
 * @author Aleksey Fiodorov
 * @copyright Copyright (c) saint-father (https://github.com/saint-father)
 */

namespace App\Models\Helper;

use App\Exceptions\TickerException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * class Data provides configuration and request parameters data
 */
class Data
{
    const BLOCKCHAIN_INFO_TICKER_URL = 'https://blockchain.info/ticker';
    const VALUE_PARAM_NAME = 'value';
    const METHOD_PARAM_NAME = 'method';
    const METHOD_RATES_NAME = 'rates';
    const METHOD_CONVERT_NAME = 'convert';
    const CURRENCY_GET_PARAM_NAME = 'currency';
    const CURRENCY_FROM_PARAM_NAME = 'currency_from';
    const CURRENCY_TO_PARAM_NAME = 'currency_to';
    const SELL_CONVERT_METHOD = 'sell';
    const BUY_CONVERT_METHOD = 'buy';
    // save required fields only
    const REQUIRED_FIELDS = [self::BUY_CONVERT_METHOD, self::SELL_CONVERT_METHOD];
    // use "buy" rate for sorting
    const SORT_KEY = self::BUY_CONVERT_METHOD;
    // commission value as a percent
    const COMMISSION_PERCENT = 2;
    // BTC is default
    const DEFAULT_CURRENCY = 'BTC';

    /**
     * @var string
     */
    private string $methodName;
    /**
     * @var string|null
     */
    private ?string $currency;
    /**
     * @var string|null
     */
    private ?string $currencyFrom;
    /**
     * @var string|null
     */
    private ?string $currencyTo;
    /**
     * @var string|null
     */
    private ?string $convertMethod;
    /**
     * @var string|null
     */
    private ?string $value;

    /**
     * Get request parameters and initialize helper
     *
     * @param Request $request
     * @return $this
     * @throws TickerException
     */
    public function init(Request $request) : self
    {
        $this->methodName = $request->{self::METHOD_PARAM_NAME};
        $this->currency = $request->{self::CURRENCY_GET_PARAM_NAME};
        $this->currencyFrom = $request->{self::CURRENCY_FROM_PARAM_NAME};
        $this->currencyTo = $request->{self::CURRENCY_TO_PARAM_NAME};
        $this->convertMethod = self::BUY_CONVERT_METHOD;
        $this->value = $request->{self::VALUE_PARAM_NAME};

        if ($this->methodName == self::METHOD_CONVERT_NAME) {
            if ($this->currencyFrom == self::DEFAULT_CURRENCY && !empty($this->currencyTo)) {
                $this->currency = $this->currencyTo;
                $this->convertMethod = self::SELL_CONVERT_METHOD;
            } elseif (!empty($this->currencyFrom)) {
                $this->currency = $this->currencyFrom;
                
                if ($this->value < 0.01) {
                    throw new TickerException(
                        __(":cur amount too small", ['cur' => $this->currencyFrom]),
                        JsonResponse::HTTP_BAD_REQUEST
                    );
                }
            } else {
                throw new TickerException('Incorrect request data', JsonResponse::HTTP_BAD_REQUEST);
            }
        }

        return $this;
    }

    /**
     * Return "method" parameter value
     * @return string
     */
    public final function getMethodName() : string
    {
        return $this->methodName;
    }

    /**
     * Return "currency" parameter value
     *
     * @return string|null
     */
    public final function getCurrency() : ?string
    {
        return $this->currency;
    }

    /**
     * Return "currency_from" parameter value
     *
     * @return string|null
     */
    public final function getCurrencyFrom() : ?string
    {
        return $this->currencyFrom;
    }

    /**
     * Return "currency_to" parameter value
     *
     * @return string|null
     */
    public final function getCurrencyTo() : ?string
    {
        return $this->currencyTo;
    }

    /**
     * Return currency conversation method (buy or sell)
     *
     * @return string|null
     */
    public final function getConvertMethod() : ?string
    {
        return $this->convertMethod;
    }

    /**
     * Return "value" parameter value
     *
     * @return float|null
     */
    public final function getValue() : ?float
    {
        return (float) $this->value;
    }
}
