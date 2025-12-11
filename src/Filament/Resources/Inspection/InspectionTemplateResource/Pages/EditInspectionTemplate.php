<?php

namespace Dpb\Package\TaskMS\UI\Filament\Resources\Inspection\InspectionTemplateResource\Pages;

use Dpb\Package\TaskMS\UI\Filament\Resources\Inspection\InspectionTemplateResource;
use Dpb\Package\TaskMS\Models\InspectionTemplateAssignment;
use Dpb\Package\Fleet\Models\VehicleModel;
use Dpb\Package\TaskMS\Models\InspectionTemplatable;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

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
    //     $ticketItemRepo = app(TicketItemRepository::class);
    //     $result = $ticketItemRepo->update($record, $data);

    //     return $result;
    // }    
}
