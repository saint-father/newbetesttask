<?php
/**
 * @author Aleksey Fiodorov
 * @copyright Copyright (c) saint-father (https://github.com/saint-father)
 */

namespace App\Http\Controllers\Api;

use App\Exceptions\TickerException;
use App\Http\Controllers\Controller;
use App\Models\BtnConverterFactory;
use App\Models\Helper\Data as DataHelper;
use App\Models\IConvertor;
use App\Models\RateCollector;
use App\Models\RateCollectorFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TickerController extends Controller
{
    /**
     * @var BtnConverterFactory
     */
    private BtnConverterFactory $btnConverterFactory;
    /**
     * @var DataHelper
     */
    private DataHelper $dataHelper;
    /**
     * @var RateCollectorFactory
     */
    private RateCollectorFactory $rateCollectorFactory;

    /**
     * TickerController constructor
     *
     * @param BtnConverterFactory $btnConverterFactory
     * @param RateCollectorFactory $rateCollectorFactory
     * @param DataHelper $dataHelper
     */
    public function __construct(
        BtnConverterFactory $btnConverterFactory,
        RateCollectorFactory $rateCollectorFactory,
        DataHelper $dataHelper
    ) {
        $this->btnConverterFactory = $btnConverterFactory;
        $this->dataHelper = $dataHelper;
        $this->rateCollectorFactory = $rateCollectorFactory;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->dataHelper->init($request); // @TODO need to use registry pattern
        /** @var RateCollector $rateCollector */
        $rateCollector = $this->rateCollectorFactory->getCollector($this->dataHelper);

        if ($request->getMethod() == 'GET' && $this->dataHelper->getMethodName() == 'rates') {

            return $this->sendResponse($rateCollector->getRateCollection());

        } elseif ($request->getMethod() == 'POST' && $this->dataHelper->getMethodName() == 'convert') {
            /** @var IConvertor $btnConverter */
            $btnConverter = $this->btnConverterFactory->getConverter($this->dataHelper->getConvertMethod(), $rateCollector);
            $result = [
                'currency_from' => $this->dataHelper->getCurrencyFrom(),
                'currency_to' => $this->dataHelper->getCurrencyTo(),
                'value' => $this->dataHelper->getValue(),
                'rate' => $this->btnConverterFactory->getInitialRate()
            ];
            // @TODO need to use Fasade pattern
            return $this->sendResponse(array_merge($result, $btnConverter->convert($this->dataHelper->getValue())->getResult()));
        } else {
            throw new TickerException('Request type and method inconsistecy', JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * success response method.
     *
     * @param mixed $result
     * @param array|string $message
     * @param int $code
     * @return JsonResponse
     */
    public function sendResponse($result, $message = '', $code = JsonResponse::HTTP_OK) : JsonResponse
    {
        $response = [
            'status' => 'success',
            'code' => $code,
            'data'    => $result
        ];

        return response()->json($response, $code);
    }
}
