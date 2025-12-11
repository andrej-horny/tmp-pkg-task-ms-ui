<?php

namespace Dpb\Package\TaskMS\UI\Mappers\Ticket;

use Dpb\Package\TaskMS\Commands\Ticket\UpdateTicketCommand;
use Dpb\Package\TaskMS\Commands\TicketAssignment\UpdateTicketAssignmentCommand;
use Dpb\Package\TaskMS\Commands\Task\UpdateTaskCommand;
use Dpb\Package\TaskMS\Commands\TaskAssignment\UpdateTaskAssignmentCommand;
use Dpb\Package\TaskMS\Mappers\TicketTypeToTaskGroupMapper;
use Dpb\Package\TaskMS\States;
use Dpb\Package\Tasks\Models\PlaceOfOrigin;
use Dpb\Package\Fleet\Models\Vehicle;
use Dpb\Package\TaskMS\Models\TicketAssignment;

class TicketUpdateFormMapper
{
    public function __construct(
        private TicketTypeToTaskGroupMapper $mapper,
    ) {}

    public function fromForm(TicketAssignment $record, array $data): array
    {
        // create ticket
        $ticketCommand = new UpdateTicketCommand(
            $record->ticket->id,
            new \DateTimeImmutable($data['date']),
            $data['description'] ?? null,
            $data['type_id'],
            States\Ticket\Created::$name,
        );

        // create ticket assignment
        $subject = Vehicle::find($data['subject_id'])->first();
        $ticketAssignmentCommand = new UpdateTicketAssignmentCommand(
            $record->id,
            $record->ticket->id,
            $subject->id,
            $subject->getMorphClass(),
        );

        return [
            'ticketCommand' => $ticketCommand,
            'ticketAssignmentCommand'  => $ticketAssignmentCommand,
        ];
    }
}
