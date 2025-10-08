<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Roadmap extends BaseController
{
    public function index()
    {
        $session = session();

        // Initialize tasks array in session if not set
        if (!$session->has('tasks')) {
            $session->set('tasks', []);
        }

        $tasks = $session->get('tasks');
        $action = $this->request->getPost('action');

        switch ($action) {
            case 'create':
                $newTask = [
                    'id' => uniqid(),
                    'title' => $this->request->getPost('title'),
                    'description' => $this->request->getPost('description'),
                    'priority' => $this->request->getPost('priority'),
                    'status' => $this->request->getPost('status'),
                ];
                $tasks[] = $newTask;
                $session->set('tasks', $tasks);
                break;

            case 'update':
                $id = $this->request->getPost('id');
                foreach ($tasks as &$task) {
                    if ($task['id'] === $id) {
                        $task['title'] = $this->request->getPost('title');
                        $task['description'] = $this->request->getPost('description');
                        $task['priority'] = $this->request->getPost('priority');
                        $task['status'] = $this->request->getPost('status');
                        break;
                    }
                }
                $session->set('tasks', $tasks);
                break;

            case 'delete':
                $id = $this->request->getPost('id');
                $tasks = array_filter($tasks, fn($t) => $t['id'] !== $id);
                $session->set('tasks', array_values($tasks));
                break;
        }

        $editTask = null;
        if ($this->request->getPost('edit')) {
            $id = $this->request->getPost('id');
            foreach ($tasks as $task) {
                if ($task['id'] === $id) {
                    $editTask = $task;
                    break;
                }
            }
        }

        return view('user/roadmap', [
            'tasks' => $tasks,
            'editTask' => $editTask
        ]);
    }
}
