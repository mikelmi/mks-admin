<?php


namespace Mikelmi\MksAdmin\Http\Middleware;


use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, \Closure $next, $guard = null)
    {
        if (\Gate::denies('admin.access')) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401, ['X-Redirect-Url' => route('admin.login')]);
            } elseif (\Auth::guard($guard)->check()) {
                return view('admin::auth.denied');
            } else {
                return redirect()->guest(route('admin.login'));
            }
        }

        return $next($request);
    }
}