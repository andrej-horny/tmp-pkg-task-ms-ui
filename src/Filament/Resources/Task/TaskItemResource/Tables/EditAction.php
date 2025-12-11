<?php

namespace Dpb\Package\TaskMS\UI\Filament\Resources\Task\TaskItemResource\Tables;

use Dpb\Package\TaskMS\Models\TaskAssignment;
use Dpb\Package\TaskMS\Models\TaskItemAssignment;
use Dpb\Package\TaskMS\Workflows\UpdateTaskItemWorkflow;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\EditAction as TablesEditAction;
use Illuminate\Database\Eloquent\Model;

class EditAction
{
    public static function make(): TablesEditAction
    {
        return TablesEditAction::make()
            ->modalWidth(MaxWidth::class)
            ->modalHeading(__('tms-ui::tasks/task-item.update_heading', ['code' => '', 'subject' => '']))
            ->mutateRecordDataUsing(function (
                $record,
                array $data,
                TaskAssignment $taskAssignment,
                TaskItemAssignment $taskItemAssignment,
            ): array {
                // subject
                $subjectId = $taskAssignment->whereBelongsTo($record->task)->first()?->subject?->id;
                $data['subject_id'] = $subjectId;

                // assigned to
                $assignedToId = $taskItemAssignment->whereBelongsTo($record, 'taskItem')->first()?->assignedTo?->id;
                $data['assigned_to'] = $assignedToId;
                // dd($data);
                return $data;
            })
            ->using(function (Model $record, array $data, UpdateTaskItemWorkflow $svc ): ?Model {
                // dd($data);
                return $svc->execute($record->id, $record->task->id, $data);
            });
    }
}
