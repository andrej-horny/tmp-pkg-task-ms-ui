<?php

namespace Dpb\Package\TaskMS\UI\Filament\Resources\Ticket\TicketAssignmentResource\Pages;

use Dpb\Package\TaskMS\UI\Filament\Resources\Ticket\TicketAssignmentResource;
use Dpb\Package\TaskMS\UI\Mappers\Ticket\TicketUpdateFormMapper;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Dpb\Package\TaskMS\Workflows\UpdateTicketWorkflow;

class EditTicketAssignment extends EditRecord
{
    protected static string $resource = TicketAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getTitle(): string | Htmlable
    {
        return __('tms-ui::tickets/ticket.update_heading', ['title' => $this->record->id]);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['subject_id'] = $this->record->subject_id;
        $data['date'] = $this->record->ticket->date;
        $data['description'] = $this->record->ticket->description;
        $data['type_id'] = $this->record->ticket->type_id;
        // dd($data);
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $commands = app(TicketUpdateFormMapper::class)->fromForm($record, $data);
        return app(UpdateTicketWorkflow::class)->handle(
            $commands['ticketCommand'],
            $commands['ticketAssignmentCommand'],
        );        
    }
}
