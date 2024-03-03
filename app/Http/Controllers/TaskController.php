<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\StoreTaskRequest;

class TaskController extends Controller
{

    public function __construct(private TaskService $taskService)
    {
    }

    public function index(Request $request)
    {
        $tasks = $this->taskService->getTasks($request);

        return $this->response($tasks);
    }

    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->validated());

        return $this->success('task created', $task);
    }

    public function show(Task $task)
    {
      return $this->response($task);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        return $this->success('task updated', $task);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return $this->success('task deleted', $task);
    }
}
