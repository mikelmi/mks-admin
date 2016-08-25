<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 25.08.16
 * Time: 17:44
 */

namespace Mikelmi\MksAdmin\Notifications;


use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetAdminPassword extends ResetPassword
{
    public function toMail()
    {
        return (new MailMessage())
            ->view('admin::email')
            ->subject(trans('admin::passwords.subject'))
            ->line(trans('admin::passwords.mail_text'))
            ->action(trans('admin::auth.Reset Password'), route('admin.reset', $this->token))
            ->line(trans('admin::passwords.mail_note'));
    }
}