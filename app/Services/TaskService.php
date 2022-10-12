<?php

namespace App\Services;

use App\Repositories\TaskRepository;
use MongoDB\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;

class TaskService
{
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getAllFilteredData(array $data)
    {
        $tasks = $this->taskRepository->getAllFilteredData($data);
        return $tasks;
    }

    public function getById(string $id)
    {
        try {  
            $task = $this->taskRepository->getById($id);
            return $task;
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
    }

    public function create(array $data)
    {
        $validator = Validator::make($data, [
            'title'         => 'required|unique:tasks',
            'description'   => 'nullable',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }
        
        $data['description'] = isset($data['description']) ? $data['description'] : '';
        $data['is_done'] = false;

        return $this->taskRepository->create($data);
    }

    public function update(array $data)
    {
        $validator = Validator::make($data, [
            '_id'           => 'required',
            'title'         => 'nullable|unique:tasks',
            'description'   => 'nullable',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $taskId = $data['_id'];
        $editTask = [];
        if (isset($data['title'])) $editTask['title'] = $data['title'];
        if (isset($data['description'])) $editTask['description'] = $data['description'];

        try {  
            $task = $this->taskRepository->getById($taskId);
            $this->taskRepository->update($editTask, $taskId);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
    }

    public function delete(string $id)
    {
        try {  
            $task = $this->taskRepository->getById($id);
            $this->taskRepository->delete($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
    }

    public function updateStatus(string $id, bool $isDone)
    {
        $editTask = [
            'is_done' => $isDone,
        ];

        try {  
            $task = $this->taskRepository->getById($id);
            $this->taskRepository->update($editTask, $id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
    }
}