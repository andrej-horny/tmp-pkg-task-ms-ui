<?php

namespace Dpb\Package\TaskMS\UI\Filament\Resources\Ticket\TicketAssignmentResource\Pages;

use DateTimeImmutable;
use Dpb\Package\Fleet\Models\Vehicle;
use Dpb\Package\TaskMS\Commands\Task\CreateTaskCommand;
use Dpb\Package\TaskMS\Commands\Ticket\CreateTicketCommand;
use Dpb\Package\TaskMS\UI\Filament\Resources\Ticket\TicketAssignmentResource;
use Dpb\Package\TaskMS\Commands\TicketAssignment\CreateTicketAssignmentCommand;
use Dpb\Package\TaskMS\Commands\TaskAssignment\CreateTaskAssignmentCommand;
use Dpb\Package\TaskMS\Handlers\Task\CreateTaskHandler;
use Dpb\Package\TaskMS\Handlers\TaskAssignment\CreateTaskAssignmentHandler;
use Dpb\Package\TaskMS\Handlers\Ticket\CreateTicketHandler;
use Dpb\Package\TaskMS\Handlers\TicketAssignment\CreateTicketAssignmentHandler;
use Dpb\Package\TaskMS\Services\CreateTicketWorkflowService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Dpb\Package\TaskMS\States;
use Dpb\Package\Tasks\Models\TaskGroup;
use Dpb\Package\Tasks\Models\PlaceOfOrigin;
use Dpb\Package\Tickets\Models\TicketGroup;
use Illuminate\Support\Facades\DB;

class CreateTicketAssignment extends CreateRecord
{
    protected static string $resource = TicketAssignmentResource::class;

    public function getTitle(): string | Htmlable
    {
        return __('tms-ui::tickets/ticket.create_heading');
    }

    protected function handleRecordCreation(array $data): Model
    {
        return app(CreateTicketWorkflowService::class)->createFromForm($data);
    }
}
