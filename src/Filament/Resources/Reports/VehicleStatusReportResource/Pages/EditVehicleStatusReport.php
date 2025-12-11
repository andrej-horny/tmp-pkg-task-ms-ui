<?php

namespace Dpb\Package\TaskMS\UI\Filament\Resources\Reports\VehicleStatusReportResource\Pages;

use Dpb\Package\TaskMS\UI\Filament\Resources\Reports\VehicleStatusReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVehicleStatusReport extends EditRecord
{
    protected static string $resource = VehicleStatusReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
