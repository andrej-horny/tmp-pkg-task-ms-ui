<?php

namespace Dpb\Package\TaskMS\UI\Mappers\TaskItem;

use Dpb\Package\TaskMS\Commands\TaskItem\UpdateTaskItemCommand;
use Dpb\Package\TaskMS\Commands\TaskItemAssignment\UpdateTaskItemAssignmentCommand;
use Dpb\Package\TaskMS\Models\TaskItemAssignment;
use Dpb\Package\TaskMS\States;

class TaskItemUpdateFormMapper
{
    public function fromForm(TaskItemAssignment $record, array $data): array
    {
        // update task
        $taskItemCommand = new UpdateTaskItemCommand(
            $record->taskItem->id,
            new \DateTimeImmutable($data['date']),
            $record->taskItem->task->id,
            $data['title'] ?? null,
            $data['description'] ?? null,
            States\Task\TaskItem\Created::$name,
            $data['group_id'] ?? null,
        );

        // update task assignment
        $taskItemAssignmentCommand = new UpdateTaskItemAssignmentCommand(
            $record->id,
            $record->task->id,
            isset($data['assigned_to_id']) ?? null,
            isset($data['assigned_to_id']) ? 'maintenance-group' : null
        );

        return [
            'taskItemCommand' => $taskItemCommand,
            'taskItemAssignmentCommand' => $taskItemAssignmentCommand
        ];
    }
}
