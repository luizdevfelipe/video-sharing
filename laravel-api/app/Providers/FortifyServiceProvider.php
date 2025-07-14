<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController;
use Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Fortify\Http\Controllers\TwoFactorSecretKeyController;

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
        Fortify::ignoreRoutes();

        Route::prefix('api')
            ->middleware(config('fortify.middleware', ['web']))
            ->group(function () {
                // Login & logout
                Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
                Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

                // Email verification
                if (Features::enabled(Features::emailVerification())) {
                    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, '__invoke']);
                    Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->name('verification.verify');
                }

                // Password reset
                Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name("password.reset");
                Route::post('/reset-password', [NewPasswordController::class, 'store']);


                // Password confirmation
                Route::get('/confirmed-password-status', [ConfirmedPasswordStatusController::class, 'show'])
                    ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
                    ->name('password.confirmation');

                Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
                    ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
                    ->name('password.confirm.store');

                // Two Factor Authentication...
                $twoFactorLimiter = config('fortify.limiters.two-factor');

                Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store'])
                    ->middleware(array_filter([
                        'guest:' . config('fortify.guard'),
                        $twoFactorLimiter ? 'throttle:' . $twoFactorLimiter : null,
                    ]))->name('two-factor.login.store');

                $twoFactorMiddleware = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
                    ? [config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard'), 'password.confirm']
                    : [config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')];

                Route::post('/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store'])
                    ->middleware($twoFactorMiddleware)
                    ->name('two-factor.enable');

                Route::post('/confirmed-two-factor-authentication', [ConfirmedTwoFactorAuthenticationController::class, 'store'])
                    ->middleware($twoFactorMiddleware)
                    ->name('two-factor.confirm');

                Route::delete('/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])
                    ->middleware($twoFactorMiddleware)
                    ->name('two-factor.disable');

                Route::get('/two-factor-qr-code', [TwoFactorQrCodeController::class, 'show'])
                    ->middleware($twoFactorMiddleware)
                    ->name('two-factor.qr-code');

                Route::get('/two-factor-secret-key', [TwoFactorSecretKeyController::class, 'show'])
                    ->middleware($twoFactorMiddleware)
                    ->name('two-factor.secret-key');

                Route::get('/two-factor-recovery-codes', [RecoveryCodeController::class, 'index'])
                    ->middleware($twoFactorMiddleware)
                    ->name('two-factor.recovery-codes');

                Route::post('/two-factor-recovery-codes', [RecoveryCodeController::class, 'store'])
                    ->middleware($twoFactorMiddleware);
            });

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();

            if ($user) {
                if ($user->google_id) {
                    return null;
                } else if (Hash::check($request->password, $user->password)) {
                    return $user;
                }
            }

            return null;
        });

        ResetPassword::createUrlUsing(function ($notifiable, string $token) {
            $url = 'http://127.0.0.1:5173/reset-password/' . $token . '?email=' . urlencode($notifiable->getEmailForPasswordReset());
            return $url;
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
