<?php

namespace Invoke\Laravel\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Invoke\Laravel\Services\InvokeService;

class InvokeController extends Controller
{
    protected InvokeService $invokeService;

    public function __construct(Request $request, InvokeService $invokeService)
    {
        $this->invokeService = $invokeService;

        if ($functionClass = $this->invokeService->getFunctionClass($request->route("functionName"))) {
            $authEnabled = config("invoke.auth.enable", true);

            if ($authEnabled && $functionClass::$secure) {
                $this->middleware(config("invoke.auth.middleware", "auth"));
            }
        }
    }

    public function invoke(Request $request, string $functionName): JsonResponse
    {
        $params = $request->all();

        $result = $this->invokeService->invoke($functionName, $params);

        return $this->makeResponse($result);
    }

    public function invokeWithVersion(Request $request, int $version, string $functionName): JsonResponse
    {
        $params = $request->all();

        $result = $this->invokeService->invoke($functionName, $params, $version);

        return $this->makeResponse($result);
    }

    public function makeResponse($result): JsonResponse
    {
        return Response::json([
            "result" => $result,
        ]);
    }
}
