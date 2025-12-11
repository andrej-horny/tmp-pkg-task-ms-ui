<?php

namespace Dpb\Package\TaskMS\UI\Mappers\Inspection;

use Dpb\Package\TaskMS\Commands\Inspection\UpdateInspectionCommand;
use Dpb\Package\TaskMS\Commands\InspectionAssignment\UpdateInspectionAssignmentCommand;
use Dpb\Package\TaskMS\Commands\Task\UpdateTaskCommand;
use Dpb\Package\TaskMS\Commands\TaskAssignment\UpdateTaskAssignmentCommand;
use Dpb\Package\TaskMS\Mappers\InspectionTypeToTaskGroupMapper;
use Dpb\Package\TaskMS\States;
use Dpb\Package\Tasks\Models\PlaceOfOrigin;
use Dpb\Package\Fleet\Models\Vehicle;
use Dpb\Package\TaskMS\Models\InspectionAssignment;

class InspectionUpdateFormMapper
{
    public function __construct(
    ) {}

    public function fromForm(InspectionAssignment $record, array $data): array
    {
        // create inspection
        $inspectionCommand = new UpdateInspectionCommand(
            $record->inspection->id,
            new \DateTimeImmutable($data['date']),
            $data['template_id'] ?? null,
            States\Inspection\Upcoming::$name,
        );

        // create inspection assignment
        $subject = Vehicle::find($data['subject_id'])->first();
        $inspectionAssignmentCommand = new UpdateInspectionAssignmentCommand(
            $record->id,
            $record->inspection->id,
            $subject->id,
            $subject->getMorphClass(),
        );

        return [
            'inspectionCommand' => $inspectionCommand,
            'inspectionAssignmentCommand'  => $inspectionAssignmentCommand,
        ];
    }
}
