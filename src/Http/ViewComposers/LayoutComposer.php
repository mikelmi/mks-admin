<?php


namespace Mikelmi\MksAdmin\Http\ViewComposers;


use Illuminate\View\View;

class LayoutComposer
{
    private $scripts = [];

    public function __construct()
    {
        $this->scripts = config('admin.scripts', []);

        if (!is_array($this->scripts)) {
            $this->scripts = [];
        }

        array_walk($this->scripts, function(&$item) {
            if (!starts_with($item, 'http:') && starts_with($item, 'https:')) {
                $item = asset($item);
            }
        });
    }

    public function compose(View $view)
    {
        $view->with('scripts', $this->scripts);
    }
}