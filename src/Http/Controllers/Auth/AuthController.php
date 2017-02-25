<?php


namespace Mikelmi\MksAdmin\Http\Controllers\Auth;


use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Mikelmi\MksAdmin\Http\Controllers\Controller;

class AuthController extends Controller
{
    use AuthenticatesUsers {
            logout as baseLogout;
        }

    public function __construct()
    {
        $this->redirectPath = route('admin');
        $this->redirectAfterLogout = $this->redirectPath;

        $this->middleware('admin.guest', ['except' => 'logout']);
        $this->middleware('admin.locale');
    }

    public function showLoginForm()
    {
        return view('admin::auth.login', [
            'username' => $this->loginUsername(),
            'reset_enable' => config('admin.reset_enable')
        ]);
    }

    public function loginUsername()
    {
        return config('admin.username', 'username');
    }

    protected function getFailedLoginMessage()
    {
        return Lang::has('admin::auth.failed')
            ? Lang::get('admin::auth.failed')
            : 'These credentials do not match our records.';
    }

    protected function getLockoutErrorMessage($seconds)
    {
        return Lang::has('admin::auth.throttle')
            ? Lang::get('admin::auth.throttle', ['seconds' => $seconds])
            : 'Too many login attempts. Please try again in '.$seconds.' seconds.';
    }

    public function logout(Request $request)
    {
        /** @var RedirectResponse $response */
        $response = $this->baseLogout($request);
        $response->setTargetUrl(route('admin'));
        
        return $response;
    }
}