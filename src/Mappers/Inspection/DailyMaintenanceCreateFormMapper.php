<?php

namespace Dpb\Package\TaskMS\UI\Mappers\Inspection;

use Dpb\Package\TaskMS\Commands\Inspection\CreateInspectionCommand;
use Dpb\Package\TaskMS\Commands\InspectionAssignment\CreateInspectionAssignmentCommand;
use Dpb\Package\TaskMS\Commands\Task\CreateTaskCommand;
use Dpb\Package\TaskMS\Commands\TaskAssignment\CreateTaskAssignmentCommand;
use Dpb\Package\TaskMS\Commands\TaskItem\CreateTaskItemCommand;
use Dpb\Package\TaskMS\States;
use Dpb\Package\Tasks\Models\PlaceOfOrigin;
use Dpb\Package\Tasks\Models\TaskGroup;

class DailyMaintenanceCreateFormMapper
{
    public function fromForm(array $data): array
    {
        $commands = [];
        foreach ($data['vehicles'] as $vehicleId) {
            // create inspection
            $inspectionCommand = new CreateInspectionCommand(
                new \DateTimeImmutable($data['date']),
                $data['inspection-template'] ?? null,
                States\Inspection\Upcoming::$name,
            );

            // create inspection assignment
            $inspectionAssignmentCommand = new CreateInspectionAssignmentCommand(
                null,
                $vehicleId,
                'vehicle',
            );

            // create task
            $taskGroupId = TaskGroup::byCode('daily-maintenance')->first()->id;
            $placeOfOriginId = PlaceOfOrigin::byUri('during-maintenance')->first()?->id;
            $taskCommand = new CreateTaskCommand(
                new \DateTimeImmutable(),
                null,
                null,
                $taskGroupId,
                States\Task\Task\Created::$name,
                $placeOfOriginId
            );

            // create task assignment
            $taskAssignmentCommand = new CreateTaskAssignmentCommand(
                null,
                $vehicleId,
                'vehicle',
                null,
                null, //$inspection->getMorphClass(),
                auth()->user()->id,
                null, //$record->subject->maintenanceGroup->id,
                null //record->subject->maintenanceGroup->getMorphClass()
            );

            // // create task items
            // $groupId = TaskGroup::byUri('daily-maintenance')->first()->id;
            // $templatables = 
            // $taskItem = new CreateTaskItemCommand(
            //     $data['date'],
            //     $vehicleId,
            //     'vehicle',
            //     null,
            //     States\Task\TaskItem\Created::$name,                
            //     $groupId
            // );

            $commands[$vehicleId] = [
                'inspectionCommand' => $inspectionCommand,
                'inspectionAssignmentCommand'  => $inspectionAssignmentCommand,
                'taskCommand'  => $taskCommand,
                'taskAssignmentCommand'  => $taskAssignmentCommand
            ];
        }

        return $commands;        
    }
}
