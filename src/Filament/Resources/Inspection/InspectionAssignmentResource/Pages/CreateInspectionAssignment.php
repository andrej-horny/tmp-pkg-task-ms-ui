<?php

namespace Dpb\Package\TaskMS\UI\Filament\Resources\Inspection\InspectionAssignmentResource\Pages;

use Dpb\Package\TaskMS\UI\Filament\Resources\Inspection\InspectionAssignmentResource;
use Dpb\Package\TaskMS\UI\Mappers\Inspection\InspectionCreateFormMapper;
use Dpb\Package\TaskMS\Workflows\CreateInspectionWorkflow;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class CreateInspectionAssignment extends CreateRecord
{
    protected static string $resource = InspectionAssignmentResource::class;

    public function getTitle(): string | Htmlable
    {
        return __('tms-ui::inspections/inspection.create_heading');
    }

    protected function handleRecordCreation(array $data): Model
    {
        $commands = app(InspectionCreateFormMapper::class)->fromForm($data);
        return app(CreateInspectionWorkflow::class)->handle(
            $commands['inspectionCommand'],
            $commands['inspectionAssignmentCommand'],
        );
    }
}
