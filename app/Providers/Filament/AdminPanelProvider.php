<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Pages\Settings;
use App\Livewire\MyCustomProfileComponent;
use App\Livewire\Register;
use BezhanSalleh\FilamentLanguageSwitch\FilamentLanguageSwitchPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\UserMenuItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\SpatieLaravelTranslatablePlugin;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('/')
            ->login()
            ->authGuard('web')
            ->registration(\App\Filament\Pages\Auth\Register::class)
            ->emailVerification()
            ->passwordReset()
            ->colors([
                'primary' => Color::Amber,
            ])

            ->plugins([
                FilamentLanguageSwitchPlugin::make()
                    ->renderHookName('panels::global-search.end'),
                    BreezyCore::make()
                        ->myProfile(
                            shouldRegisterUserMenu: true,
                            shouldRegisterNavigation: false,
                            hasAvatars: true ,// Enables the avatar upload form component (default = false)
                        )
                        ->avatarUploadComponent(fn($fileUpload) => $fileUpload->disableLabel())
                        ->passwordUpdateRules(
                            rules: ['"^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$^"'], // you may pass an array of validation rules as well. (default = ['min:8'])
                            requiresCurrentPassword: true // when false, the user can update their password without entering their current password. (default = true)
                        )
                        ->enableTwoFactorAuthentication(
                            force: false, // force the user to enable 2FA before they can use the application (default = false)
                        )
                ]
            )

        ->navigationGroups([
                __('objects.users'),

            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,

            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
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
            ])
            ->navigationGroups([
                NavigationGroup::make()
                    ->label(__('objects.users'))
            ])
            ->userMenuItems([
                MenuItem::make()
                    ->label('Settings')
                    ->url(fn (): string => Settings::getUrl())
                    ->icon('heroicon-o-cog-6-tooth')// ...
            ]);
    }
}
