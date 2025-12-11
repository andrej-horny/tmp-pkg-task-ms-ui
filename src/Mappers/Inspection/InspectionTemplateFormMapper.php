<?php

namespace Dpb\Package\TaskMS\UI\Mappers\Inspection;

use Dpb\Package\TaskMS\Commands\InspectionTemplatable\CreateInspectionTemplatableCommand;
use Dpb\Package\TaskMS\Commands\InspectionTemplate\CreateInspectionTemplateCommand;

class InspectionTemplateFormMapper
{
    public function fromForm(array $data): array
    {
        // create inspection
        $inspectionTemplateCommand = new CreateInspectionTemplateCommand(
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
            ->map(fn($templatableId) => new CreateInspectionTemplatableCommand(
                null,
                $templatableId,
                'vehicle-model'
            ))
            ->all();

        return [
            'inspectionCommand' => $inspectionTemplateCommand,
            'templatablesCommands'  => $templatablesCommands
        ];
    }
}
