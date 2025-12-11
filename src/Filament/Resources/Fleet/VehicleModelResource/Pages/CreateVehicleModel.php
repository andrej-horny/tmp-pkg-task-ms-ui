<?php

namespace Dpb\Package\TaskMS\UI\Filament\Resources\Fleet\VehicleModelResource\Pages;

use Dpb\Package\TaskMS\UI\Filament\Resources\Fleet\VehicleModelResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateVehicleModel extends CreateRecord
{
    protected static string $resource = VehicleModelResource::class;

    public function getTitle(): string | Htmlable
    {
        return __('tms-ui::fleet/vehicle-model.create_heading');
    }      
}
