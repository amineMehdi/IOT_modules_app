<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\ModuleHistory;

class ModuleHistoryController extends Controller
{
    public function store(Module $module) {

        $newEntry = [
            'module_id' => $module->id,
            'name' => $module->name,
            'description' => $module->description,
            'type' => $module->type,
            'temperature' => $module->temperature,
            'speed' => $module->speed,
            'online' => $module->online,
            'functional' => $module->functional,
        ];
        ModuleHistory::create($newEntry);
    }

    public function destroy(Module $module) {
        ModuleHistory::where('module_id', $module->id)->delete();
    }

}
