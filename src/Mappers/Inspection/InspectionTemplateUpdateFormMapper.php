<?php

namespace Dpb\Package\TaskMS\UI\Mappers\Inspection;

use Dpb\Package\Inspections\Models\InspectionTemplate;
use Dpb\Package\TaskMS\Commands\InspectionTemplatable\CreateInspectionTemplatableCommand;
use Dpb\Package\TaskMS\Commands\InspectionTemplatable\UpdateInspectionTemplatableCommand;
use Dpb\Package\TaskMS\Commands\InspectionTemplate\CreateInspectionTemplateCommand;
use Dpb\Package\TaskMS\Commands\InspectionTemplate\UpdateInspectionTemplateCommand;
use Dpb\Package\TaskMS\Resolvers\InspectionTemplatableResolver;

class InspectionTemplateUpdateFormMapper
{
    public function __construct(
        private InspectionTemplatableResolver $templatableResolver
    ) {}

    public function fromForm(InspectionTemplate $record, array $data): array
    {
        // create inspection
        $inspectionTemplateCommand = new UpdateInspectionTemplateCommand(
            $record->id,
            $data['code'],
            $data['title'],
            $data['description'] ?? null,
            $data['is_periodic'] ?? 0,
            $data['treshold_distance'],
            $data['first_advance_distance'],
            $data['second_advance_distance'],
            $data['treshold_time'],
            $data['first_advance_time'],
            $data['second_advance_time'],
        );

        // create inspection templatables
        // dd($data['templatables']);
        $templatablesCommands = collect($data['templatables'] ?? [])
            ->map(function ($templatableId) use ($record) {
                $templatable = $this->templatableResolver->resolve('vehicle-model', $templatableId);
                return new UpdateInspectionTemplatableCommand(
                    $record->id,
                    $templatable->id,
                    $templatable->morphClass
                );
            })
            ->all();

        return [
            'inspectionTemplateCommand' => $inspectionTemplateCommand,
            'templatablesCommands'  => $templatablesCommands
        ];
    }
}
