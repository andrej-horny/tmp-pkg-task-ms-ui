<?php

namespace Dpb\Package\TaskMS\UI\Filament\Resources\Ticket\TicketAssignmentResource\Pages;

use Dpb\Package\TaskMS\UI\Filament\Resources\Ticket\TicketAssignmentResource;
use Dpb\Package\TaskMS\UI\Mappers\Ticket\TicketCreateFormMapper;
use Dpb\Package\TaskMS\Workflows\CreateTicketWorkflow;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;


class CreateTicketAssignment extends CreateRecord
{
    protected static string $resource = TicketAssignmentResource::class;

    public function getTitle(): string | Htmlable
    {
        return __('tms-ui::tickets/ticket.create_heading');
    }

    protected function handleRecordCreation(array $data): Model
    {
        $commands = app(TicketCreateFormMapper::class)->fromForm($data);
        return app(CreateTicketWorkflow::class)->handle(
            $commands['ticketCommand'],
            $commands['ticketAssignmentCommand'],
            $commands['taskCommand'],
            $commands['taskAssignmentCommand'],
        );
    }
}
