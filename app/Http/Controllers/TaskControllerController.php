<?php

namespace App\Http\Controllers;

use App\Models\TaskController;
use Illuminate\Http\Request;

class TaskControllerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $taskcontroller = TaskController::all();
            return response()->json($taskcontroller, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            TaskController::create($request->all());
            return response()->json(['message' => 'Tarefa criada com sucesso!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TaskController  $taskController
     * @return \Illuminate\Http\Response
     */
    public function show(TaskController $taskController)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaskController  $taskController
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        try {
            $taskcontroller = TaskController::findOrFail($id);
            $taskcontroller->update($request->all());
            return response()->json(['message' => 'Tarefa atualizada com sucesso!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaskController  $taskController
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $taskcontroller = TaskController::findOrFail($id);
            $taskcontroller->delete();
            return response()->json(['message' => 'Tarefa deletada com sucesso!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
