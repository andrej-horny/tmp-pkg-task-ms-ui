<?php

namespace Dpb\Package\TaskMS\UI\Mappers\Ticket;

use Dpb\Package\TaskMS\Commands\Ticket\CreateTicketCommand;
use Dpb\Package\TaskMS\Commands\TicketAssignment\CreateTicketAssignmentCommand;
use Dpb\Package\TaskMS\Commands\Task\CreateTaskCommand;
use Dpb\Package\TaskMS\Commands\TaskAssignment\CreateTaskAssignmentCommand;
use Dpb\Package\TaskMS\Mappers\TicketTypeToTaskGroupMapper;
use Dpb\Package\TaskMS\States;
use Dpb\Package\Tasks\Models\PlaceOfOrigin;
use Dpb\Package\Fleet\Models\Vehicle;
use Dpb\Package\TaskMS\Commands\TaskAssignment\CreateFromTicketCommand;
use Dpb\Package\TaskMS\Resolvers\TaskAssigneeResolver;
use Dpb\Package\TaskMS\Resolvers\TaskSourceResolver;
use Dpb\Package\TaskMS\Resolvers\TaskSubjectResolver;
use Dpb\Package\TaskMS\Resolvers\TicketSubjectResolver;

class TicketCreateFormMapper
{
    public function __construct(
        private TicketTypeToTaskGroupMapper $mapper,
        private TicketSubjectResolver $ticketSubjectResolver,
        private TaskSubjectResolver $taskSubjectResolver,
        // private TaskSourceResolver $taskSourceResolver,
        // private TaskAssigneeResolver $taskAssigneeResolver,
    ) {}

    public function fromForm(array $data): array
    {
        // create ticket
        $ticketCommand = new CreateTicketCommand(
            new \DateTimeImmutable($data['date']),
            $data['description'] ?? null,
            $data['type_id'],
            States\Ticket\Created::$name,
        );

        // create ticket assignment
        // $subject = Vehicle::find($data['subject_id'])->first();
        $ticketSubject = $this->ticketSubjectResolver->resolve('vehicle', $data['subject_id']);
        $ticketAssignmentCommand = new CreateTicketAssignmentCommand(
            null,
            $ticketSubject->id,
            $ticketSubject->morphClass,
            auth()->user()->id,
        );

        // create task
        $taskGroupId = $this->mapper->mapTicketTypeIdToTaskGroupId($data['type_id']);
        $placeOfOriginId = PlaceOfOrigin::byUri('in-service')->first()?->id;
        $taskCommand = new CreateTaskCommand(
            new \DateTimeImmutable($data['date']),
            null,
            $data['description'] ?? null,
            $taskGroupId,
            States\Task\Task\Created::$name,
            $placeOfOriginId
        );

        // create task assignment
        $taskSubject = $this->taskSubjectResolver->resolve('vehicle', $data['subject_id']);
        // $taskSource = $this->taskSourceResolver->resolve('ticket', $data['subject_id']);
        // $taskAssignee = $this->taskAssigneeResolver->resolve('maintenance-group', $);
        $taskAssignmentCommand = new CreateFromTicketCommand(
            null,
            $taskSubject->id,
            $taskSubject->morphClass,
            null,
            null,
            auth()->user()->id,
            null,
            null,
            // $taskAssignee->id ?? null,
            // $taskAssignee->morphClass ?? null
        );

        return [
            'ticketCommand' => $ticketCommand,
            'ticketAssignmentCommand'  => $ticketAssignmentCommand,
            'taskCommand' => $taskCommand,
            'taskAssignmentCommand' => $taskAssignmentCommand,
        ];
    }
}
