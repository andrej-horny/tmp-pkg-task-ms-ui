<?php

namespace Dpb\Package\TaskMS\UI\Mappers\Task;

use Dpb\Package\TaskMS\Commands\Task\UpdateTaskCommand;
use Dpb\Package\TaskMS\Commands\TaskAssignment\UpdateTaskAssignmentCommand;
use Dpb\Package\TaskMS\Models\TaskAssignment;
use Dpb\Package\TaskMS\States;

class TaskUpdateFormMapper
{
    public function fromForm(TaskAssignment $record, array $data): array
    {
        // update task
        $taskCommand = new UpdateTaskCommand(
            $record->task->id,
            new \DateTimeImmutable($data['task']['date']),
            $data['title'] ?? null,
            $data['task']['description'] ?? null,
            $data['task']['group_id'] ?? null,
            States\Task\Task\Created::$name,
        );

        // update task assignment
        $taskAssignmentCommand = new UpdateTaskAssignmentCommand(
            $record->id,
            $record->task->id,
            $data['subject_id'],
            'vehicle',
            null,
            null,
            isset($data['assigned_to_id']) ?? null,
            isset($data['assigned_to_id']) ? 'maintenance-group' : null
        );

        return [
            'taskCommand' => $taskCommand,
            'taskAssignmentCommand' => $taskAssignmentCommand
        ];
    }
}
