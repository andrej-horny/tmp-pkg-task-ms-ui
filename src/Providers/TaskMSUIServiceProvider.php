<?php

namespace Dpb\Package\TaskMS\UI\Providers;

use Dpb\Package\TaskMS\UI\Filament\Resources\Fleet\VehicleResource;
use Filament\Facades\Filament;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

// resources
use Dpb\Package\TaskMS\UI\Filament\Resources;

class TaskMSUIServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('pkg-task-ms-ui');
            // ->publishesServiceProvider('TaskMSFilamentPanelProvider');
    }

    public function packageBooted(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'tms-ui');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'tms-ui');

        // Register Livewire component manually for package
        Livewire::component('tables.fleet.vehicle.inspections', VehicleResource\Tables\InspectionsTable::class);
        Livewire::component('tables.fleet.vehicle.malfunctions', VehicleResource\Tables\MalfunctionsTable::class);

        // Register Filament resources
        // Filament::serving(function () {
        //     $panel = Filament::getCurrentPanel();
        //     $currentResources = $panel->getResources();

        //     // Add resources from other packages
        //     $panel->resources([
        //         ...$currentResources,
        //         // tasks
        //         Resources\Task\TaskGroupResource::class,
        //         Resources\Task\TaskItemGroupResource::class,
        //         Resources\Task\TaskItemResource::class,
        //         Resources\Task\TaskAssignmentResource::class,
        //         Resources\Task\PlaceOfOriginResource::class,
        //         // tickets
        //         Resources\Ticket\TicketAssignmentResource::class,
        //         Resources\Ticket\TicketTypeResource::class,
        //         // inspections
        //         Resources\Inspection\InspectionAssignmentResource::class,
        //         Resources\Inspection\DailyMaintenanceResource::class,
        //         Resources\Inspection\InspectionTemplateGroupResource::class,
        //         Resources\Inspection\InspectionTemplateResource::class,
        //         Resources\Inspection\UpcomingInspectionResource::class,
        //         // // fleet
        //         // Resources\Fleet\DailyExpeditionResource::class,
        //         Resources\Fleet\MaintenanceGroupResource::class,
        //         Resources\Fleet\VehicleResource::class,
        //         Resources\Fleet\BrandResource::class,
        //         Resources\Fleet\VehicleGroupResource::class,
        //         Resources\Fleet\VehicleModelResource::class,
        //         Resources\Fleet\VehicleTypeResource::class,
        //         // reports
        //         Resources\Reports\VehicleStatusReportResource::class,

        //     ]);
        // });
    }
}
