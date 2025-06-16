<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Filament\Navigation\NavigationItem; // ✅ IMPORTANTE

use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])

            // ✅ AÑADE AQUÍ LAS OPCIONES DE MENÚ
            ->navigationItems([
                NavigationItem::make('Roles & Permissions')
                    ->icon('heroicon-o-lock-closed')
                    ->url('#'),

                NavigationItem::make('Resources')
                    ->icon('heroicon-o-archive-box')
                    ->url('#'),

                NavigationItem::make('Clients')
                    ->icon('heroicon-o-user-group')
                    ->url('#'),

                NavigationItem::make('Compliance')
                    ->icon('heroicon-o-document-check')
                    ->url('#'),

                NavigationItem::make('Reinsurers')
                    ->icon('heroicon-o-building-office')
                    ->url('#'),

                NavigationItem::make('Underwritten')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->url('#'),

                NavigationItem::make('Transactions')
                    ->icon('heroicon-o-arrows-right-left')
                    ->url('#'),

                NavigationItem::make('Statistics')
                    ->icon('heroicon-o-chart-bar')
                    ->url('#'),
            ])


            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
