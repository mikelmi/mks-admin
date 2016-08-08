<?php


namespace Mikelmi\MksAdmin\Http\Middleware;


use Illuminate\Http\Request;

class SetAdminLocale
{
    public function handle(Request $request, \Closure $next)
    {
        if ($request->has('_lang') && ($lang = $request->get('_lang'))) {
            return back()->cookie(\Cookie::forever('a_lc', $lang));
        }

        app()->setLocale($request->cookie('a_lc', config('admin.locale')));

        return $next($request);
    }
}