<?php


namespace Mikelmi\MksAdmin\Http\Controllers;


use Mikelmi\MksAdmin\Contracts\MenuManagerContract;

class IndexController extends AdminController
{
    public function index()
    {
        return view('admin::layout');
    }

    public function home()
    {
        return view('admin::index.home');
    }

    public function menu(MenuManagerContract $menuManager)
    {
        $items = $menuManager->getItems();

        return response()->json($items);
    }
}