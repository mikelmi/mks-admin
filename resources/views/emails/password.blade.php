{{trans('admin::passwords.mail_body')}}: <a href="{{ $link = route('admin.reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
