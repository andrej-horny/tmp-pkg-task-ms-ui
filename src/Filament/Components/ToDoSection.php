<?php

namespace Dpb\Package\TaskMS\UI\Filament\Components;

use Dpb\Package\TaskMS\Models\Datahub\Department;
use Closure;
use Filament\Forms;

/**
 * Extends Filament Select component.
 * 
 * Presets label and filtering. If needed it can be overriden
 * and used like original Select component.
 * Both custom methods have to be called with null as input parameter
 * to apply custom bevaiour.  
 */
class ToDoSection 
{
    public static function make()
    {
        return Forms\Components\Section::make('TO DO')
        ->label('TO DO: pripravujeme');
    }
}
