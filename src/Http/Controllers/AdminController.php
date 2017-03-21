<?php


namespace Mikelmi\MksAdmin\Http\Controllers;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

abstract class AdminController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('admin.locale');
        $this->middleware('admin');

        $this->setupMiddlewares();

        $this->init();
    }

    protected function init()
    {

    }

    protected function setupMiddlewares()
    {

    }
    
    protected function redirect($to = null, $status = 302, $headers = [], $secure = null)
    {
        $url = $to;

        if (is_array($to)) {
            $submitFlag = (int) \Request::header('X-Submit-Flag', 0);
            if (array_key_exists($submitFlag, $to)) {
                $url = $to[$submitFlag];
            } else {
                $url = array_first($to);
            }
        }

        if (\Request::ajax()) {
            $base = route('admin');
            $headers['X-Redirect-Path'] = preg_replace('#^'.preg_quote($base).'#', '', $url);

            return response('', $status, $headers);
        }

        $headers['X-Redirect-Url'] = $url;

        return redirect($to, $status, $headers, $secure);
    }

    public function flashMessage($message, $type='info')
    {
        \Session::flash('flash-message', [
            'class' => $type == 'error' ? 'alert-danger' : 'alert-' . $type,
            'type' => $type,
            'message' => $message,
        ]);
    }

    public function flashSuccess($message)
    {
        $this->flashMessage($message, 'success');
    }

    public function flashError($message)
    {
        $this->flashMessage($message, 'error');
    }

    public function flashInfo($message)
    {
        $this->flashMessage($message, 'info');
    }

    public function flashNotice($message)
    {
        $this->flashMessage($message, 'notice');
    }
}