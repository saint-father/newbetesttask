<?php
/**
 * @author Aleksey Fiodorov
 * @copyright Copyright (c) saint-father (https://github.com/saint-father)
 */

namespace App\Models;

class BtnConverter implements IConvertor
{
    /**
     * @var mixed
     */
    private $rate;
    /**
     * @var float
     */
    private $converted;

    /**
     * Convert currency value
     *
     * @param float $value
     * @return $this
     */
    public function convert(float $value) : self
    {
        $this->converted = $value * $this->rate;

        return $this;
    }

    /**
     * Object initializer
     *
     * @param $rate
     * @return $this
     */
    public function init($rate) : self
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get formatted result
     *
     * @param array|null $result
     * @return array
     * @TODO resul formatter should be injected in initializer
     */
    public function getResult(?array $result = []) : array
    {
        $converted = trim(number_format($this->converted, 10), '0');

        return [...$result, 'converted_value' => $converted];
    }
}
