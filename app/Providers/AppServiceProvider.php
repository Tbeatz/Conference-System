<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Global Blade helper to highlight search keywords
        if (!function_exists('highlight')) {
            /**
             * Highlight search keyword in a string
             */
            function highlight($text, $keyword)
            {
                if (!$keyword) return e($text);

                // Escape text and keyword for safe HTML
                $text = e($text);
                $keyword = preg_quote($keyword, '/');

                // Wrap matching keyword in <span class="highlight">
                return preg_replace("/($keyword)/i", '<span class="highlight">$1</span>', $text);
            }
        }
    }
}
