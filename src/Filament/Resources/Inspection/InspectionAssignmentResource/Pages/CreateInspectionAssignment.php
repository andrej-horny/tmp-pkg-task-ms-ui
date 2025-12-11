<?php

namespace Dpb\Package\TaskMS\UI\Filament\Resources\Inspection\InspectionAssignmentResource\Pages;

use Dpb\Package\TaskMS\Handlers\InspectionAssignment\CreateInspectionAssignmentHandler;
use Dpb\Package\TaskMS\Commands\Inspection\CreateInspectionCommand;
use Dpb\Package\TaskMS\Commands\InspectionAssignment\CreateInspectionAssignmentCommand;
use Dpb\Package\TaskMS\UI\Filament\Resources\Inspection\InspectionAssignmentResource;
use Dpb\Package\TaskMS\Handlers\Inspection\CreateInspectionHandler;
use Dpb\Package\TaskMS\Services\CreateInspectionWorkflowService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Dpb\Package\TaskMS\States;
use Illuminate\Support\Facades\DB;

class CreateInspectionAssignment extends CreateRecord
{
    protected static string $resource = InspectionAssignmentResource::class;

    public function getTitle(): string | Htmlable
    {
        return __('tms-ui::inspections/inspection.create_heading');
    }

    protected function handleRecordCreation(array $data): Model
    {
        return app(CreateInspectionWorkflowService::class)->createFromForm($data);
    }
}
