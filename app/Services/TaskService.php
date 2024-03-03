<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskService extends Service
{
    public function getTasks(Request $request)
    {
        $query = Task::query();

        if ($request->has('status')) {
            $status = $request->input('status');
            $query->where('completed', $status);
        }

        if ($request->has('date')) {
            $date = $request->input('date');
            $query->whereDate('created_at', $date);
        }

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $tasks = $query->latest('created_at')->get();

        return $tasks;
    }
}
