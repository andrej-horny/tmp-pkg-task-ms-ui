<?php

namespace Dpb\Package\TaskMS\UI\Filament\Resources\Inspection\InspectionTemplateResource\Forms;

use Dpb\Package\TaskMS\UI\Filament\Resources\Fleet\Vehicle\BrandResource\Forms\BrandPicker;
use Dpb\Package\TaskMS\UI\Filament\Resources\Fleet\Vehicle\VehicleTypeResource\Forms\VehicleTypePicker;
use Dpb\Package\Activities\Models\ActivityTemplate;
use Dpb\Package\Fleet\Models\Vehicle;
use Dpb\Package\Fleet\Models\VehicleModel;
use Filament\Forms;
use Filament\Forms\Form;

class VehicleModelsTab
{
    public static function make(): array
    {
        return [
            Forms\Components\CheckboxList::make('templatables')
                ->label(__('tms-ui::inspections/inspection-template.form.fields.templatables.label'))
                ->hint(__('tms-ui::inspections/inspection-template.form.fields.templatables.hint'))
                ->options(function () {
                    return VehicleModel::get()
                        ->mapWithKeys(fn($vehicle) => [
                            $vehicle->id => $vehicle->title
                        ]);
                })
                ->searchable()
                ->bulkToggleable(true)
                ->columnSpanFull()
                ->columns(10)
        ];
    }
}
