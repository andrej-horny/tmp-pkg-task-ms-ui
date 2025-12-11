<?php

namespace Dpb\Package\TaskMS\UI\Mappers\Ticket;

use Dpb\Package\TaskMS\Commands\Ticket\UpdateTicketCommand;
use Dpb\Package\TaskMS\Commands\TicketAssignment\UpdateTicketAssignmentCommand;
use Dpb\Package\TaskMS\States;
use Dpb\Package\TaskMS\Models\TicketAssignment;
use Dpb\Package\TaskMS\Resolvers\TicketSubjectResolver;

class TicketUpdateFormMapper
{
    public function __construct(
        private TicketSubjectResolver $ticketSubjectResolver,
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
        // $subject = Vehicle::find($data['subject_id'])->first();
        $ticketSubject = $this->ticketSubjectResolver->resolve('vehicle', $data['subject_id']);
        $ticketAssignmentCommand = new UpdateTicketAssignmentCommand(
            $record->id,
            $record->ticket->id,
            $ticketSubject->id,
            $ticketSubject->morphClass
        );

        return [
            'ticketCommand' => $ticketCommand,
            'ticketAssignmentCommand'  => $ticketAssignmentCommand,
        ];
    }
}
