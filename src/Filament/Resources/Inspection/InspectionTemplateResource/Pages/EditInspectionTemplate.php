<?php

namespace Dpb\Package\TaskMS\UI\Filament\Resources\Inspection\InspectionTemplateResource\Pages;

use Dpb\Package\TaskMS\UI\Filament\Resources\Inspection\InspectionTemplateResource;
use Dpb\Package\TaskMS\Models\InspectionTemplateAssignment;
use Dpb\Package\Fleet\Models\VehicleModel;
use Dpb\Package\TaskMS\Handlers\Inspection\UpdateInspectionHandler;
use Dpb\Package\TaskMS\Models\InspectionTemplatable;
use Dpb\Package\TaskMS\UI\Mappers\Inspection\InspectionTemplateUpdateFormMapper;
use Dpb\Package\TaskMS\Workflows\UpdateInspectionTemplateWorkflow;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class EditInspectionTemplate extends EditRecord
{
    protected static string $resource = InspectionTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getTitle(): string | Htmlable
    {
        return __('tms-ui::inspections/inspection-template.update_heading', ['title' => $this->record->title]);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // tempalables / vehicle models
        $vehicleModelMorphClass = app(VehicleModel::class)->getMorphClass();
        $vehicleModels = InspectionTemplatable::whereBelongsTo($this->record, 'template')
            ->whereMorphedTo('templatable', $vehicleModelMorphClass)
            ->pluck('templatable_id')
            ->toArray();
        $data['templatables'] = $vehicleModels;

        return $data;
    }

    // protected function handleRecordUpdate(Model $record, array $data): Model
    // {
    //     $commands = app(InspectionTemplateUpdateFormMapper::class)->fromForm($record, $data);
    //     return app(UpdateInspectionTemplateWorkflow::class)->handle(
    //         $commands['inspectionTemplateCommand'],
    //         $commands['templatablesCommands'],
    //     );
    // }
}
