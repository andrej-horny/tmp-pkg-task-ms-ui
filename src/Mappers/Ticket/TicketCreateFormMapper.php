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

class TicketCreateFormMapper
{
    public function __construct(
        private TicketTypeToTaskGroupMapper $mapper,
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
        $subject = Vehicle::find($data['subject_id'])->first();
        $ticketAssignmentCommand = new CreateTicketAssignmentCommand(
            null,
            $subject->id,
            $subject->getMorphClass(),
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
        $taskAssignmentCommand = new CreateTaskAssignmentCommand(
            null,
            $data['subject_id'],
            'vehicle',
            null,
            null,
            auth()->user()->id,
            $data['assigned_to_id'] ?? null,
            isset($data['assigned_to_id']) ? 'maintenance-group' : null
        );

        return [
            'ticketCommand' => $ticketCommand,
            'ticketAssignmentCommand'  => $ticketAssignmentCommand,
            'taskCommand' => $taskCommand,
            'taskAssignmentCommand' => $taskAssignmentCommand,
        ];
    }
}
