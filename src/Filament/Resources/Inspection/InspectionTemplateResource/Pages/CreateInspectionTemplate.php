<?php

namespace Dpb\Package\TaskMS\UI\Filament\Resources\Inspection\InspectionTemplateResource\Pages;

use Dpb\Package\TaskMS\UI\Filament\Resources\Inspection\InspectionTemplateResource;
use Dpb\Package\TaskMS\UI\Mappers\Inspection\InspectionTemplateFormMapper;
use Dpb\Package\TaskMS\Workflows\CreateInspectionTemplateWorkflow;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class CreateInspectionTemplate extends CreateRecord
{
    protected static string $resource = InspectionTemplateResource::class;

    public function getTitle(): string | Htmlable
    {
        return __('tms-ui::inspections/inspection-template.create_heading');
    }  

    public function handleRecordCreation(array $data): Model
    {
        $commands = app(InspectionTemplateFormMapper::class)->fromForm($data);
        return app(CreateInspectionTemplateWorkflow::class)->handle(
            $commands['inspectionCommand'],
            $commands['templatablesCommands'],
        );
    }
}
