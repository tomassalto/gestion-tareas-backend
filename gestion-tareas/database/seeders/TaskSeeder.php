<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskProgress;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priorities = ['Baja', 'Media', 'Alta'];

        foreach (range(1, 10) as $i) {

            $userIds = User::where('rol', 1)->inRandomOrder()->take(rand(0, 5))->pluck('id');
            $totalUsers = $userIds->count();

            $status = 'Pendiente';
            $completedUsersCount = 0;

            if ($totalUsers > 0) {
                $completedUsersCount = rand(0, $totalUsers);
                if ($completedUsersCount === 0) {
                    $status = 'Pendiente';
                } elseif ($completedUsersCount === $totalUsers) {
                    $status = 'Completada';
                } else {
                    $status = 'En progreso';
                }
            }

            $task = Task::create([
                'title' => "Tarea {$i}",
                'description' => "Descripción de la tarea {$i}",
                'status' => $status,
                'priority' => $priorities[array_rand($priorities)],
            ]);

            $task->users()->sync($userIds);


            foreach ($userIds as $index => $userId) {
                $isCompleted = $index < $completedUsersCount;
                TaskProgress::create([
                    'task_id' => $task->id,
                    'user_id' => $userId,
                    'is_completed' => $isCompleted,
                ]);
            }

            if ($status === 'completada' && $totalUsers === 0) {
                throw new \Exception("La tarea {$task->id} no puede estar completada sin usuarios asignados.");
            }
        }
    }
}
