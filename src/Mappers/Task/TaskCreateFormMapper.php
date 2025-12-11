<?php

namespace Dpb\Package\TaskMS\UI\Mappers\Task;

use Dpb\Package\TaskMS\Commands\Task\CreateTaskCommand;
use Dpb\Package\TaskMS\Commands\TaskAssignment\CreateTaskAssignmentCommand;
use Dpb\Package\TaskMS\Resolvers\TaskSubjectResolver;
use Dpb\Package\TaskMS\States;
use Dpb\Package\Tasks\Models\PlaceOfOrigin;

class TaskCreateFormMapper
{
    public function __construct(
        private TaskSubjectResolver $taskSubjectResolver,
    ) {}

    public function fromForm(array $data): array
    {
        // create task
        $placeOfOriginId = PlaceOfOrigin::byUri('during-maintenance')->first()->id;
        $taskCommand = new CreateTaskCommand(
            new \DateTimeImmutable($data['task']['date']),
            $data['title'] ?? null,
            $data['task']['description'] ?? null,
            $data['task']['group_id'] ?? null,
            States\Task\Task\Created::$name,
            $placeOfOriginId
        );

        // create task assignment
        $taskSubject = $this->taskSubjectResolver->resolve('vehicle', $data['subject_id']);
        $taskAssignmentCommand = new CreateTaskAssignmentCommand(
            null,
            $taskSubject->id,
            $taskSubject->morphClass,
            null,
            null,
            auth()->user()->id,
            null,
            null,
        );

        return [
            'taskCommand' => $taskCommand,
            'taskAssignmentCommand' => $taskAssignmentCommand
        ];
    }
}
