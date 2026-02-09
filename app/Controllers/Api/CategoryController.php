<?php

namespace App\Controllers\Api;

use App\Models\Category;
use App\Middleware\Auth;
use App\Middleware\Csrf;
use PDO;

class CategoryController
{
    private $model;

    public function __construct(PDO $pdo)
    {
        $this->model = new Category($pdo);
    }

    public function index()
    {
        $this->json($this->model->getAll());
    }

    public function show($id)
    {
        $category = $this->model->getById((int) $id);
        if (!$category) {
            $this->json(['error' => 'Category not found'], 404);
            return;
        }
        $this->json($category);
    }

    public function store()
    {
        Auth::requireAuth();
        Csrf::validate();

        $input = json_decode(file_get_contents('php://input'), true);
        $errors = $this->validate($input);
        if ($errors) {
            $this->json(['errors' => $errors], 422);
            return;
        }

        $id = $this->model->create($input);
        $this->json($this->model->getById($id), 201);
    }

    public function update($id)
    {
        Auth::requireAuth();
        Csrf::validate();

        $category = $this->model->getById((int) $id);
        if (!$category) {
            $this->json(['error' => 'Category not found'], 404);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $errors = $this->validate($input);
        if ($errors) {
            $this->json(['errors' => $errors], 422);
            return;
        }

        $this->model->update((int) $id, $input);
        $this->json($this->model->getById((int) $id));
    }

    public function destroy($id)
    {
        Auth::requireAuth();
        Csrf::validate();

        $category = $this->model->getById((int) $id);
        if (!$category) {
            $this->json(['error' => 'Category not found'], 404);
            return;
        }

        $this->model->delete((int) $id);
        $this->json(['success' => true]);
    }

    public function reorder()
    {
        Auth::requireAuth();
        Csrf::validate();

        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['ids']) || !is_array($input['ids'])) {
            $this->json(['error' => 'Invalid input'], 400);
            return;
        }

        foreach ($input['ids'] as $index => $id) {
            $this->model->updateSortOrder((int) $id, $index + 1);
        }

        $this->json(['success' => true]);
    }

    private function validate($input)
    {
        $errors = [];
        if (empty($input['nameCro'])) {
            $errors[] = 'nameCro is required';
        }
        if (empty($input['nameEn'])) {
            $errors[] = 'nameEn is required';
        }
        return $errors;
    }

    private function json($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
