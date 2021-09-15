<?php

namespace App\Http\Controllers;

use App\Http\Requests\JsonRpcRequest;
use App\Services\JsonRpc\JsonRpcError;
use App\Services\JsonRpc\JsonRpcResponse;
use App\Services\MethodHandler;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{

    public function index(JsonRpcRequest $jsonRpcRequest)
    {

        $method = $jsonRpcRequest->get('method');
        $params = $jsonRpcRequest->get('params');
        $id = $jsonRpcRequest->get('id');

        $methodHandler = new MethodHandler();

        if (!method_exists($methodHandler, $method)) {
            return Response::json(JsonRpcResponse::createError(JsonRpcError::METHOD_NOT_FOUND));
        }

        try {
            return Response::json(
                JsonRpcResponse::create($methodHandler->{$method}($params, $id), $id)
            );
        } catch (\Exception $e) {
            return Response::json(JsonRpcResponse::createError(JsonRpcError::INTERNAL_ERROR));
        }

    }

}
