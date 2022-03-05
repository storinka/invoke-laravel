<?php

namespace Invoke\Laravel\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Invoke\Invoke;
use Symfony\Component\HttpFoundation\Response;

class InvokeController extends Controller
{
    /**
     * Invoke a method.
     *
     * @param string $method
     * @param Invoke $invoke
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(string  $method,
                             Invoke  $invoke,
                             Request $request): JsonResponse
    {
        /// get all parameters from request
        $params = $request->all();

        /// create new response instance
        $response = new JsonResponse();

        /// register the response instance in container
        /// to be able to use it during invocation
        app()->instance(Response::class, $response);

        /// invoke the method
        $result = $invoke->invoke($method, $params);

        /// remove response instance from the container
        app()->forgetInstance(Response::class);

        /// return wrapped result
        return $response->setData([
            "result" => $result,
        ]);
    }
}
