<?php

namespace Dpb\Package\TaskMS\UI\Filament\Resources\Task\TaskAssignmentResource\Pages;

use Dpb\Package\TaskMS\UI\Filament\Resources\Task\TaskAssignmentResource;
use Dpb\Package\TaskMS\UI\Mappers\Task\TaskCreateFormMapper;
use Dpb\Package\TaskMS\Workflows\CreateTaskWorkflow;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class CreateTaskAssignment extends CreateRecord
{
    protected static string $resource = TaskAssignmentResource::class;

    public function getTitle(): string | Htmlable
    {
        return __('tms-ui::tasks/task.create_heading');
    }

    protected function handleRecordCreation(array $data): Model
    {
        $commands = app(TaskCreateFormMapper::class)->fromForm($data);
        return app(CreateTaskWorkflow::class)->handle(
            $commands['taskCommand'],
            $commands['taskAssignmentCommand'],
        );        
    }
}
