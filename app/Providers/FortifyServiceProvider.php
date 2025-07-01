<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        //register
        Fortify::registerView(function () {
            return view('auth-cover.register', [
                "title" => "Register",
            ]);
        });

        //login
        Fortify::loginView(function (Request $request) {
            return view('auth-cover.login', [
                'title' => 'Login',
            ]);
        });

        //forgot
        Fortify::requestPasswordResetLinkView(function () {
            return view('auth-cover.forgot-password', [
                "title" => "Forgot Password",
            ]);
        });

        //reset
        Fortify::resetPasswordView(function ($request) {
            return view('auth-cover.reset-password', [
                "title" => "Reset Password",
                'request' => $request,
            ]);
        });

        //verify
        Fortify::verifyEmailView(function () {
            return view('auth-cover.verify-email', [
                "title" => "Verify Email",
            ]);
        });

        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $emailResetUrl = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));
            return (new MailMessage)
                ->subject('Reset Password Notification')
                ->view('email.reset-password.index', [
                    'user' => $notifiable,
                    'url' => $emailResetUrl,
                    'title' => 'Password Reset'
                ]);
        });

        VerifyEmail::toMailUsing(function ($notifiable, $verificationUrl) {
            return (new MailMessage)
                ->subject('Verify Email Address')
                ->view('user.mail.verify-mail', [
                    'user' => $notifiable,
                    'url' => $verificationUrl
                ]);
        });
    }
}
