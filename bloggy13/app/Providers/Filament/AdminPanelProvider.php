<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

use BezhanSalleh\LanguageSwitch\LanguageSwitch;
use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;

use Filament\Forms\Components\Field;
use Filament\Tables\Columns\Column;
use Filament\Infolists\Components\Entry;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class AdminPanelProvider extends PanelProvider
{
    private function __getLocales()
    {
        return array_keys(config('app.available_locales', ['en']));
    }

    public function panel(Panel $panel): Panel
    {
        $locales = $this->__getLocales();

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugin(
                SpatieTranslatablePlugin::make()
                    ->persist()
                    ->defaultLocales($locales),
            );
    }

    public function boot(): void
    {
        $locales = $this->__getLocales();

        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) use ($locales) {
            $switch->locales($locales);
        });

        // Sistema dinàmic de traducció d'etiquetes basat en claus
        
        foreach ([Field::class, Column::class, Entry::class] as $componentClass) {
            $componentClass::configureUsing(function ($component): void {
                $name = $component->getName();

                if (blank($name)) {
                    return;
                }

                $component->label(function() use ($name) : string {
                    $name = strtolower($name);
                    $segments = explode('.', $name);

                    // 1. Traducció específica: author.name
                    $key = 'labels.' . $name;
                    if (Lang::has($key)) {
                        return __($key);
                    }

                    // 2. Traducció de l'entitat: author
                    if (count($segments) > 1) {
                        $entityKey = 'labels.' . $segments[0];

                        if (Lang::has($entityKey)) {
                            return __($entityKey);
                        }
                    }

                    // 3. Traducció genèrica de l'atribut: name
                    $attributeKey = 'labels.' . end($segments);
                    if (Lang::has($attributeKey)) {
                        return __($attributeKey);
                    }

                    // 4. Etiqueta automàtica
                    return Str::headline(end($segments));
                });
            });
        }
    }
}
