<?php

namespace Kakhura\LaravelGalleriable\Http\Controllers\Request;

use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Kakhura\LaravelGalleriable\Helpers\Helper;
use Kakhura\LaravelGalleriable\Models\Request\RequestIdentifier;
use Kakhura\LaravelGalleriable\Services\RequestIdentifier\RequestIdentifierService;

class CheckController extends Controller
{
    public function check(string $requestId, RequestIdentifierService $requestIdentifierService)
    {
        /** @var RequestIdentifier $request */
        $request = $requestIdentifierService->getRequest($requestId, config('kakhura.galleriable.use_auth_user_check') ? auth()->user() : null);
        if (is_null($request)) {
            return Helper::response(false, [], 404, ['messasge' => trans('messages.request_identifier_not_found')]);
        }
        return Helper::response(true, [
            'id' => $request->model->uuid ?: $request->model->id,
            'model' => Str::snake(Str::afterLast($request->model_type, "\\")),
        ]);
    }
}
