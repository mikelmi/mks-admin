<?php


namespace Mikelmi\MksAdmin\Http\ViewComposers;


use Illuminate\View\View;

class LayoutComposer
{
    /**
     * @var array
     */
    private $scripts = [];

    /**
     * @var array
     */
    private $styles = [];

    private $appModules = [];


    public function __construct()
    {
        $this->scripts = config('admin.scripts', []);
        $this->styles = config('admin.styles', []);
        $this->appModules = config('admin.appModules', []);

        if (!is_array($this->scripts)) {
            $this->scripts = [];
        }

        array_unshift($this->scripts, 'vendor/mikelmi/mks-smart-table/js/mks-smart-table-st.js');
        array_unshift($this->appModules, 'mks-smart-table');

        array_walk($this->scripts, function(&$item) {
            if (!starts_with($item, 'http:') && starts_with($item, 'https:')) {
                $item = asset($item);
            }
        });

        if (!is_array($this->styles)) {
            $this->styles = [];
        }

        array_walk($this->styles, function(&$item) {
            if (!starts_with($item, 'http:') && starts_with($item, 'https:')) {
                $item = asset($item);
            }
        });
    }

    public function compose(View $view)
    {
        $view->with('scripts', $this->scripts);
        $view->with('styles', $this->styles);
        $view->with('appModules', json_encode($this->appModules));
    }
}