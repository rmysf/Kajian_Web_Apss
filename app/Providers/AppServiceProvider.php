<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
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
        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            return (new MailMessage)
                ->subject('Reset Kata Sandi Anda')
                ->greeting('Reset Kata Sandi Anda')
                ->line('Halo!')
                ->line('Anda menerima email ini karena kami menerima permintaan reset kata sandi untuk akun KajianKu Anda. Silakan klik tombol di bawah ini untuk membuat kata sandi baru.')
                ->action('Reset Kata Sandi', url(route('password.reset', [
                    'token' => $token,
                    'email' => $notifiable->getEmailForPasswordReset(),
                ], false)))
                ->line('Tautan reset kata sandi ini akan kedaluwarsa dalam ' . config('auth.passwords.'.config('auth.defaults.passwords').'.expire') . ' menit. Jika Anda tidak meminta reset kata sandi, abaikan saja email ini.')
                ->salutation(new \Illuminate\Support\HtmlString(' '));
        });
    }
}
