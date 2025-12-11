<?php

namespace Dpb\Package\TaskMS\UI\Filament\Resources\Task\TaskAssignmentResource\RelationManagers;

use Dpb\Package\TaskMS\UI\Filament\Resources\Task\TaskItemResource\Forms\TaskItemForm;
use Dpb\Package\TaskMS\UI\Filament\Resources\Task\TaskItemResource\Tables\TaskItemTable;
use Dpb\Package\TaskMS\Services\AddTaskItemWorkflowService;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TaskItemRelationManager extends RelationManager
{
    protected static string $relationship = 'taskItems';

    public function form(Form $form): Form
    {
        return TaskItemForm::make($form);
    }

    public function table(Table $table): Table
    {
        return TaskItemTable::make($table)
            ->headerActions([
                CreateAction::make()
                    ->modalHeading(__('tms-ui::tasks/task-item.create_heading'))
                    ->using(function (array $data, AddTaskItemWorkflowService $svc): ?Model {
                        $taskId = $this->getOwnerRecord()->task->id;
                        return $svc->execute($taskId, $data);
                    })
                    ->modalWidth(MaxWidth::class),
            ]);
    }
}
