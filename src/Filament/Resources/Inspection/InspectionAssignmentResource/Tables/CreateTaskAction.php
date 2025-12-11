<?php

namespace Dpb\Package\TaskMS\UI\Filament\Resources\Inspection\InspectionAssignmentResource\Tables;

use Dpb\Package\TaskMS\Commands\Task\CreateTaskCommand;
use Dpb\Package\TaskMS\Commands\TaskAssignment\CreateTaskAssignmentCommand;
use Dpb\Package\TaskMS\Handlers\Task\CreateTaskHandler;
use Dpb\Package\TaskMS\Handlers\TaskAssignment\CreateTaskAssignmentHandler;
use Dpb\Package\TaskMS\Models\InspectionAssignment;
use Dpb\Package\TaskMS\Models\TaskAssignment;
use Dpb\Package\TaskMS\Models\TicketAssignment;
use Dpb\Package\TaskMS\Services\CreateTaskFromInspectionWorkflowService;
use Dpb\Package\TaskMS\UseCases\TicketAssignment\CreateFromInspectionUseCase;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\DB;
use Dpb\Package\TaskMS\States;
use Dpb\Package\Tasks\Models\PlaceOfOrigin;
use Dpb\Package\Tasks\Models\TaskGroup;

class CreateTaskAction
{
    public static function make($uri): Action
    {
        return Action::make($uri)
            ->label(__('tms-ui::inspections/inspection.table.actions.create_task'))
            ->button()
            ->action(function (InspectionAssignment $record, CreateTaskFromInspectionWorkflowService $svc) {
                return $svc->createFromInspectionAssignment($record);
            })
            ->visible(function (InspectionAssignment $record) {
                // return true;
                // return $ticketAssignment->whereHasMorph($record, $record->getMorphClass());
                return !TaskAssignment::where('source_type', $record->inspection->getMorphClass())
                    ->where('source_id', $record->id)
                    ->exists();
            });
    }
}
