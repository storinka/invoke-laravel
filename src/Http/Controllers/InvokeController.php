<?php

namespace Invoke\Laravel\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Invoke\Laravel\Services\InvokeService;

class InvokeController extends Controller
{
    protected InvokeService $invokeService;

    public function __construct(InvokeService $invokeService)
    {
        $this->invokeService = $invokeService;
    }

    public function invoke(Request $request, string $method): JsonResponse
    {
        $params = $request->all();

        $result = $this->invokeService->invoke($method, $params);

        return $this->makeResponse($result);
    }

    public function makeResponse($result): JsonResponse
    {
        return $this->invokeService->response->setData([
            "result" => $result,
        ]);
    }
}
