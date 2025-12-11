<?php

namespace Dpb\Package\TaskMS\UI\Providers;

use Dpb\Package\TaskMS\UI\Filament\Resources\Fleet\VehicleResource;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TaskMSUIServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('pkg-task-ms-ui')
            ->publishesServiceProvider('TaskMSFilamentPanelProvider');
    }

    public function packageBooted(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'tms-ui');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'tms-ui');

        // Register Livewire component manually for package
        Livewire::component('tables.fleet.vehicle.inspections', VehicleResource\Tables\InspectionsTable::class);        
        Livewire::component('tables.fleet.vehicle.malfunctions', VehicleResource\Tables\MalfunctionsTable::class);        
    }
}
