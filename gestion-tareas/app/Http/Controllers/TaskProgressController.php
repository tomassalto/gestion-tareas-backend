<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskProgress;
use Illuminate\Support\Facades\Auth;

class TaskProgressController extends Controller
{
    // Actualizar el progreso de un usuario en una tarea
    public function updateProgress(Request $request, Task $task)
    {
        $user = Auth::user();

        // Validar la solicitud
        $validated = $request->validate([
            'is_completed' => 'required|boolean',
        ]);

        // Verificar si la tarea ya está completada
        if ($task->status === 'completada') {
            return response()->json(['message' => 'No se puede modificar el progreso de una tarea finalizada.'], 400);
        }

        $progress = TaskProgress::where('task_id', $task->id)
            ->where('user_id', $user->id)
            ->first();

        if (!$progress) {
            return response()->json(['message' => 'Progreso no encontrado'], 404);
        }

        $progress->update(['is_completed' => $validated['is_completed']]);

        return response()->json(['message' => 'Progreso actualizado con éxito']);
    }

    public function getAssignedTasks()
    {
        $user = Auth::user();

        $tasks = TaskProgress::where('user_id', $user->id)
            ->with(['task.users' => function ($query) {
                $query->select('users.id', 'users.email');
            }])
            ->get()
            ->map(function ($progress) use ($user) {
                return [
                    'id' => $progress->task->id,
                    'title' => $progress->task->title,
                    'description' => $progress->task->description,
                    'status' => $progress->task->status,
                    'priority' => $progress->task->priority,
                    'is_completed' => $progress->is_completed,
                    'assigned_users' => $progress->task->users
                        ->where('id', '!=', $user->id)
                        ->values(),
                ];
            });

        return response()->json($tasks);
    }
}
