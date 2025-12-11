<?php

namespace Dpb\Package\TaskMS\UI\Filament\Resources\Inspection\InspectionAssignmentResource\Pages;

use Dpb\Package\TaskMS\UI\Filament\Resources\Inspection\InspectionAssignmentResource;
use Dpb\Package\TaskMS\UI\Mappers\Inspection\InspectionUpdateFormMapper;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Dpb\Package\TaskMS\Workflows\UpdateInspectionWorkflow;

class EditInspectionAssignment extends EditRecord
{
    protected static string $resource = InspectionAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getTitle(): string | Htmlable
    {
        return __('tms-ui::inspections/inspection.update_heading', ['title' => $this->record->id]);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // $subjectId = InspectionAssignment::whereBelongsTo($this->record->inspection)->first()?->subject?->id;
        // $data['subject_id'] = $subjectId;

        // $activities = ActivityAssignment::whereMorphedTo('subject', $this->record->inspectionItem)
        //     ->with(['activity', 'activity.template'])
        //     ->get()
        //     ->map(fn($assignment) => $assignment->activity);
        // $data['activities'] = $activities;

        // assigned to
        // $assignedToId = InspectionItemAssignment::whereBelongsTo($this->record, 'inspectionItem')->first()?->assignedTo?->id;
        // $data['assigned_to'] = $assignedToId;

        $data['template_id'] = $this->record->inspection->template_id;
        $data['date'] = $this->record->inspection->date;
        // dd($data);
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $commands = app(InspectionUpdateFormMapper::class)->fromForm($record, $data);
        return app(UpdateInspectionWorkflow::class)->handle(
            $commands['inspectionCommand'],
            $commands['inspectionAssignmentCommand'],
        );    
    }
}
