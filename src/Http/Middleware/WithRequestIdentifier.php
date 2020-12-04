<?php

namespace Kakhura\LaravelGalleriable\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Kakhura\LaravelGalleriable\Exceptions\RequestIdentifierFoundException;
use Kakhura\LaravelGalleriable\Exceptions\RequestIdentifierRequiredException;
use Kakhura\LaravelGalleriable\Services\RequestIdentifier\RequestIdentifierService;

class WithRequestIdentifier
{
    protected $requestIdentifierService;

    public function __construct(RequestIdentifierService $requestIdentifierService)
    {
        $this->requestIdentifierService = $requestIdentifierService;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure  $next
     * @param string|null  $guard
     * @return mixed
     *
     * @throws RequestIdentifierRequiredException|RequestIdentifierFoundException
     */
    public function handle(Request $request, Closure $next)
    {
        if (in_array(Str::lower($request->method()), config('kakhura.galleriable.request_methods'))) {
            if (!$request->has('request_id')) {
                throw new RequestIdentifierRequiredException(trans('messages.request_identifier_required'));
            }
            if ($this->requestIdentifierService->getRequest($request->get('request_id'), config('kakhura.galleriable.use_auth_user_check') ? auth()->user() : null)) {
                throw new RequestIdentifierFoundException(trans('messages.request_identifier_found'));
            }
        }
        return $next($request);
    }
}
