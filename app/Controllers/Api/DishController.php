<?php

namespace App\Controllers\Api;

use App\Models\Dish;
use App\Middleware\Auth;
use App\Middleware\Csrf;
use PDO;

class DishController
{
    private $model;

    public function __construct(PDO $pdo)
    {
        $this->model = new Dish($pdo);
    }

    public function index()
    {
        $categoryId = $_GET['categoryId'] ?? $_REQUEST['categoryId'] ?? null;
        if ($categoryId === '') $categoryId = null;
        if ($categoryId !== null) $categoryId = (int) $categoryId;

        $this->json($this->model->getAll($categoryId));
    }

    public function show($id)
    {
        $dish = $this->model->getById((int) $id);
        if (!$dish) {
            $this->json(['error' => 'Dish not found'], 404);
            return;
        }
        $this->json($dish);
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

        $dish = $this->model->getById((int) $id);
        if (!$dish) {
            $this->json(['error' => 'Dish not found'], 404);
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

        $dish = $this->model->getById((int) $id);
        if (!$dish) {
            $this->json(['error' => 'Dish not found'], 404);
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
        if (empty($input['categoryId'])) {
            $errors[] = 'categoryId is required';
        }
        if (empty($input['nameCro'])) {
            $errors[] = 'nameCro is required';
        }
        if (empty($input['nameEn'])) {
            $errors[] = 'nameEn is required';
        }
        if (!isset($input['price']) || !is_numeric($input['price'])) {
            $errors[] = 'price must be a number';
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
