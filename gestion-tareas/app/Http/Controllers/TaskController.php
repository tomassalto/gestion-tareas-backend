<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskProgress;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['users', 'progress'])->get()->map(function ($task) {
            $totalUsers = $task->progress->count();
            $completedUsers = $task->progress->where('is_completed', true)->count();
            $progressPercentage = $totalUsers > 0 ? ($completedUsers / $totalUsers) * 100 : 0;

            return [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status,
                'priority' => $task->priority,
                'progress_percentage' => $progressPercentage,
                'users' => $task->users->map(function ($user) use ($task) {
                    $userProgress = $task->progress->firstWhere('user_id', $user->id);
                    return [
                        'id' => $user->id,
                        'email' => $user->email,
                        'is_completed' => $userProgress ? $userProgress->is_completed : false,
                    ];
                }),
            ];
        });

        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pendiente,en progreso,completada',
            'priority' => 'required|in:baja,media,alta',
            'user_ids' => 'array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $task = Task::create($validated);
        $task->users()->sync($validated['user_ids'] ?? []);
        foreach ($validated['user_ids'] as $userId) {
            TaskProgress::updateOrCreate(
                ['task_id' => $task->id, 'user_id' => $userId],
                ['is_completed' => false]
            );
        }
        return response()->json(['message' => 'Tarea creada con éxito', 'task' => $task]);
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pendiente,en progreso,completada',
            'priority' => 'required|in:baja,media,alta',
            'user_ids' => 'array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $task->update($validated);

        $currentUserIds = $task->users->pluck('id')->toArray();
        $newUserIds = $validated['user_ids'] ?? [];

        $removedUserIds = array_diff($currentUserIds, $newUserIds);

        $addedUserIds = array_diff($newUserIds, $currentUserIds);

        TaskProgress::where('task_id', $task->id)
            ->whereIn('user_id', $removedUserIds)
            ->delete();

        foreach ($addedUserIds as $userId) {
            TaskProgress::updateOrCreate(
                ['task_id' => $task->id, 'user_id' => $userId],
                ['is_completed' => false]
            );
        }

        $task->users()->sync($newUserIds);

        return response()->json(['message' => 'Tarea actualizada con éxito', 'task' => $task]);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message' => 'Tarea eliminada con éxito']);
    }

    public function getStandardUsers()
    {
        $users = User::role('user_standard')->get(['id', 'email']);
        return response()->json($users);
    }

    public function removeUserFromTask(Request $request, Task $task)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $task->users()->detach($validated['user_id']);

        return response()->json(['message' => 'Usuario eliminado de la tarea con éxito']);
    }

    public function updateBasic(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task->update($validated);

        return response()->json([
            'message' => 'Tarea actualizada con éxito',
            'task' => [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
            ],
        ]);
    }
}
