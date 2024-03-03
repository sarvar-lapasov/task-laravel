<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\StoreTaskRequest;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query();

        if ($request->has('status')) {
            $status = $request->get('status');
            $query->where('completed', $status);
        }

        if ($request->has('date')) {
            $date = $request->get('date');
            $query->whereDate('created_at', $date);
        }

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
        
        $query->orderBy('created_at', 'desc');
        $tasks = $query->get();

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
