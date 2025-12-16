<?php

namespace Dpb\Package\TaskMS\UI\Filament\Plugins;

use Filament\Contracts\Plugin;
use Filament\Panel;

// resources
use Dpb\Package\TaskMS\UI\Filament\Resources;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;

class TaskMSPlugin implements Plugin
{
    public function getId(): string
    {
        return 'task-ms-ui';
    }

    public function register(
        Panel $panel
    ): void {
        $panel
            // ->colors([
            //     'primary' => Color::Amber,
            // ])
            ->maxContentWidth(MaxWidth::Full)
            ->resources([
                // activities
                // Resources\Activity\ActivityResource::class,
                // Resources\Activity\ActivityTemplateResource::class,
                // Resources\Activity\TemplateGroupResource::class,
                // tasks
                Resources\Task\TaskGroupResource::class,
                Resources\Task\TaskItemGroupResource::class,
                Resources\Task\TaskItemResource::class,
                Resources\Task\TaskAssignmentResource::class,
                Resources\Task\PlaceOfOriginResource::class,
                // tickets
                Resources\Ticket\TicketAssignmentResource::class,
                Resources\Ticket\TicketTypeResource::class,
                // inspections
                Resources\Inspection\InspectionAssignmentResource::class,
                Resources\Inspection\DailyMaintenanceResource::class,
                Resources\Inspection\InspectionTemplateGroupResource::class,
                Resources\Inspection\InspectionTemplateResource::class,
                Resources\Inspection\UpcomingInspectionResource::class,
                // // fleet
                // Resources\Fleet\DailyExpeditionResource::class,
                Resources\Fleet\MaintenanceGroupResource::class,
                Resources\Fleet\VehicleResource::class,
                Resources\Fleet\BrandResource::class,
                Resources\Fleet\VehicleGroupResource::class,
                Resources\Fleet\VehicleModelResource::class,
                Resources\Fleet\VehicleTypeResource::class,
                // reports
                Resources\Reports\VehicleStatusReportResource::class,
            ]);
    }

    public function boot(
        Panel $panel
    ): void {}
}
