<?php


namespace Mikelmi\MksAdmin\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class PasswordController extends Controller
{
    use ResetsPasswords;

    protected $linkRequestView = 'admin::auth.email';
    protected $resetView = 'admin::auth.reset';

    public function __construct()
    {
        $this->middleware('admin.guest');
        $this->middleware('admin.locale');

        $broker = config('auth.defaults.passwords');
        if ($broker) {
            app('config')->set('auth.passwords.'.$broker.'.email', 'admin::emails.password');
        }
    }

    protected function getSendResetLinkEmailSuccessResponse($response)
    {
        return redirect()->back()->with('status', trans('admin::' . $response));
    }

    protected function getSendResetLinkEmailFailureResponse($response)
    {
        return redirect()->back()->withErrors(['email' => trans('admin::'.$response)]);
    }

    protected function getEmailSubject()
    {
        return Lang::has('admin::passwords.subject')
            ? Lang::get('admin::passwords.subject')
            : 'Your Password Reset Link';
    }

    protected function getResetSuccessResponse($response)
    {
        return redirect($this->redirectPath())->with('status', trans('admin::'.$response));
    }

    protected function getResetFailureResponse(Request $request, $response)
    {
        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans('admin::'.$response)]);
    }
}