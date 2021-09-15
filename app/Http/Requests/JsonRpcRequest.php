<?php

namespace App\Http\Requests;

use App\Services\JsonRpc\JsonRpcResponse;
use App\Services\JsonRpc\JsonRpcError;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Response;

class JsonRpcRequest extends FormRequest
{

    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'jsonrpc' => 'required|in:2.0',
            'method' => 'required',
            'params' => 'array|nullable',
            'id' => 'nullable',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            Response::json(JsonRpcResponse::createError(JsonRpcError::INVALID_REQUEST))
        );
    }

}
