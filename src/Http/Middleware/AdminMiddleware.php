<?php


namespace Mikelmi\MksAdmin\Http\Middleware;


use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, \Closure $next, $guard = null)
    {
        $response = null;

        if (\Gate::denies('admin.access')) {
            if ($request->ajax() || $request->wantsJson()) {
                $response = response('Unauthorized.', 401, ['X-Redirect-Url' => route('admin.login')]);
            } elseif (\Auth::guard($guard)->check()) {
                $response = view('admin::auth.denied');
            } else {
                $response = redirect()->guest(route('admin.login'));
            }
        }

        if (!$response) {
            $response = $next($request);
        }

        if ($request->ajax() || $request->wantsJson()) {
            if (!$response->headers->has('X-Flash-Message') && ($message = $request->session()->get('flash-message'))) {
                $response->headers->set('X-Flash-Message', urlencode($message['message']));
                $response->headers->set('X-Flash-Message-Type', $message['type']);
                $request->session()->forget('flash-message');
            }
        }

        return $response;
    }
}
