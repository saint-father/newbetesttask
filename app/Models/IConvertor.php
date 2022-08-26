<?php
/**
 * @author Aleksey Fiodorov
 * @copyright Copyright (c) saint-father (https://github.com/saint-father)
 */
namespace App\Models;

interface IConvertor
{
    /**
     * @param float $value
     * @return $this
     */
    public function convert(float $value) : self;

    /**
     * @param $rate
     * @return $this
     */
    public function init($rate) : self;

    /**
     * @param array|null $result
     * @return array
     */
    public function getResult(?array $result) : array;
}
