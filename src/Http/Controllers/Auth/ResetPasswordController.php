<?php


namespace Mikelmi\MksAdmin\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    public function __construct()
    {
        $this->middleware('admin.guest');
        $this->middleware('admin.locale');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('admin::auth.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function redirectPath()
    {
        return route('admin');
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param  string  $response
     * @return \Illuminate\Http\Response
     */
    protected function sendResetResponse($response)
    {
        return redirect($this->redirectPath())
            ->with('status', trans('admin::'.$response));
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param  \Illuminate\Http\Request
     * @param  string  $response
     * @return \Illuminate\Http\Response
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans('admin::'.$response)]);
    }
}