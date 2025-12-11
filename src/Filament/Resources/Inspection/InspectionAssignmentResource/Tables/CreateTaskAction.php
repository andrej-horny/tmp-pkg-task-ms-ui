<?php

namespace Dpb\Package\TaskMS\UI\Filament\Resources\Inspection\InspectionAssignmentResource\Tables;

use Dpb\Package\TaskMS\Models\InspectionAssignment;
use Dpb\Package\TaskMS\Models\TaskAssignment;
use Dpb\Package\TaskMS\Workflows\CreateTaskFromInspectionWorkflow;
use Filament\Tables\Actions\Action;

class CreateTaskAction
{
    public static function make($uri): Action
    {
        return Action::make($uri)
            ->label(__('tms-ui::inspections/inspection.table.actions.create_task'))
            ->button()
            ->action(function (InspectionAssignment $record, CreateTaskFromInspectionWorkflow $svc) {
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
