<?php

namespace Dpb\Package\TaskMS\UI\Filament\Resources\Task\TaskAssignmentResource\Pages;

use Dpb\Package\TaskMS\UI\Filament\Resources\Task\TaskAssignmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Dpb\Package\TaskMS\UI\Mappers\Task\TaskUpdateFormMapper;
use Dpb\Package\TaskMS\Workflows\UpdateTaskWorkflow;

class EditTaskAssignment extends EditRecord
{
    protected static string $resource = TaskAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getTitle(): string | Htmlable
    {
        return __('tms-ui::tasks/task.update_heading', ['title' => $this->record->getTitleAttribute()]);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // $data['subject_id'] = Dpb\Package\TaskMS(TaskAssignment::class)->whereBelongsTo($this->record)->first()?->subject?->id;

        // task group
        $data['task']['date'] = $this->record->task->date;
        $data['task']['group_id'] = $this->record->task->group_id;
        $data['task']['description'] = $this->record->task->description;

        // activities
        // $activities = app(ActivityService::class)->getActivities($this->record->task)->toArray();
        // $data['activities'] = $activities;
        // dd($activities);
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $commands = app(TaskUpdateFormMapper::class)->fromForm($record, $data);
        return app(UpdateTaskWorkflow::class)->handle(
            $commands['taskCommand'],
            $commands['taskAssignmentCommand'],
        );          
    }
}
