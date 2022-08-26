<?php
/**
 * @author Aleksey Fiodorov
 * @copyright Copyright (c) saint-father (https://github.com/saint-father)
 */

namespace App\Exceptions;

use Exception;

/**
 * class TickerException - custom exception renderer
 */
class TickerException extends Exception
{
    /**
     * Render the exception into an API response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json(
            ['status' => 'error', 'code' => $this->getCode(), 'message' => $this->getMessage()],
            $this->getCode()
        );
    }
}
