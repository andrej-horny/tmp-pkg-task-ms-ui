<?php

namespace Dpb\Package\TaskMS\UI\Mappers\TaskItem;

use Dpb\Package\TaskMS\Commands\TaskItem\CreateTaskItemCommand;
use Dpb\Package\TaskMS\Commands\TaskItemAssignment\CreateTaskItemAssignmentCommand;
use Dpb\Package\TaskMS\States;
use Dpb\Package\Tasks\Models\PlaceOfOrigin;

class TaskItemCreateFormMapper
{
    public function fromForm(int $taskId, array $data): array
    {
        // create task item
        $placeOfOriginId = PlaceOfOrigin::byUri('during-maintenance')->first()->id;
        $taskItemCommand = new CreateTaskItemCommand(
            new \DateTimeImmutable($data['date']),
            $taskId,
            null,
            $data['description'] ?? null,
            States\Task\TaskItem\Created::$name,
            $data['group_id']
        );

        // create task item assignment
        $taskItemAssignmentCommand = new CreateTaskItemAssignmentCommand(
            null,
            $data['assigned_to'] ?? null,
            isset($data['assigned_to']) ? 'maintenance-group' : null,
            auth()->user()->id,
        );

        return [
            'taskItemCommand' => $taskItemCommand,
            'taskItemAssignmentCommand' => $taskItemAssignmentCommand
        ];
    }
}
