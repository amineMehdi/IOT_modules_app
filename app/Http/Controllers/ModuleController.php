<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Module;
use App\Models\ModuleHistory;
use Illuminate\Support\Facades\DB;

class ModuleController extends Controller
{
    public function totalTime()
    {
        $modules = Module::all();
        $totalTime = 0;
        foreach ($modules as $module) {
            if ($module->functional) {
                $totalTime += $module->getFunctionTime();
            }
        }
        return $totalTime;
    }
    public function index()
    {
        $modules = auth()->user()->modules()->get();
        // $totalTime = 0;
        // foreach($modules as $module) {
        //     if ($module->functional) {
        //         $totalTime += $module->functionTime();
        //     }
        // }
        return view('module.index', [
            'modules' => $modules,
            'totalTime' => date("H:i:s", $this->totalTime()),
        ]);
    }

    public function create()
    {
        return view('module.create');
    }

    public function store(Request $request)
    {
        $req = $request->all();
        $req['online'] = $request->online ? true : false;
        $req['functional'] = true;
        $module = auth()->user()->modules()->create($req);

        (new ModuleHistoryController)->store($module);

        return redirect()->route('module.index')->with('success', 'Module created successfully.');
    }

    public function destroy(Module $module)
    {
        $module->delete();
        (new ModuleHistoryController)->destroy($module);
        return redirect()->route('module.index')->with('success', 'Module deleted successfully.');
    }

    public function edit(Module $module)
    {
        return view('module.edit', [
            'module' => $module,
        ]);
    }

    public function update(Module $module)
    {
        $req = request()->all();
        $req['online'] = request()->online ? true : false;
        $req['functional'] = true;

        (new ModuleHistoryController)->store($module);

        if (!$module->updateOrFail($req)) {
            return redirect()->route('module.index')->with('error', 'Module update failed.');
        }
        return redirect()->route('module.index')->with('success', 'Module updated successfully.');
    }

    public function info(Module $module)
    {
        $module->functionTime = date("H:i:s", $module->getFunctionTime());
        return response()->json($module);
    }

    public function updateStatus()
    {
        $modules = Module::all();
        $moduleHistoryController = new ModuleHistoryController;
        foreach ($modules as $module) {
            $moduleHistoryController->store($module);
            $module->online = rand(0, 1) == 1 ? true : false;
            $module->temperature = rand($module->temperature - 5, $module->temperature + 5);
            $module->speed = abs(rand($module->speed - 5, $module->speed + 5));
            $module->functional = rand(0, 1) == 1 ? true : false;
            $module->save();
        }
        return redirect()->route('module.index', ['modules' => $modules]);
    }

    public function historyModule(Module $module)
    {
        $histories = $module->histories()->get();
        return response()->json($histories);
    }

    public function types()
    {
        $types = DB::table('modules')->select('type')->distinct()->get();

        foreach ($types as $type) {
            $type->count = DB::table('modules')->where('type', $type->type)->count();
        }
        return response()->json($types);
    }
}
