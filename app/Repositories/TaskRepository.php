<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskRepository
{
    public function getAllFilteredData(array $data)
    {
        return Task::filter($data)->get();
    }

    public function getById(string $id)
    {
        try {   
            $task = Task::findOrFail($id);
            return $task;
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('ID not found.');
        }
    }

    public function create(array $data){
        $newTask = Task::create($data);
        return $newTask;
    }

    public function update(array $data, string $id)
    {
        Task::where('_id', $id)->update($data);
    }

    public function delete(string $id)
    {
        Task::destroy($id);
    }
}