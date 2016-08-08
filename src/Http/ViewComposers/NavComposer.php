<?php


namespace Mikelmi\MksAdmin\Http\ViewComposers;


use Illuminate\View\View;

class NavComposer
{

    public function compose(View $view)
    {
        $user = \Auth::user();

        $username = $user->{config('admin.username')};

        $profileUrl = config('admin.profile_url', 'javascript:void(0)');

        $siteUrl = config('admin.site_url');

        if (!$siteUrl) {
            $siteUrl = preg_replace('/' . preg_quote(route('admin', [], false), '/') .  '$/', '', route('admin'));
        }

        $locale = app()->getLocale();
        $locales = config('admin.locales', []);
        $localeTitle = $locale ? array_get($locales, $locale, 'English') : 'English';

        if (count($locales) <= 1) {
            $locales = [];
        }

        if ($locale) {
            unset($locales[$locale]);
        }

        $view->with(compact('username', 'profileUrl', 'siteUrl' ,'locales', 'locale', 'localeTitle'));
    }
}