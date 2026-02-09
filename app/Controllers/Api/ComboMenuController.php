<?php

namespace App\Controllers\Api;

use App\Models\ComboMenu;
use App\Middleware\Auth;
use App\Middleware\Csrf;
use PDO;

class ComboMenuController
{
    private $model;

    public function __construct(PDO $pdo)
    {
        $this->model = new ComboMenu($pdo);
    }

    public function index()
    {
        $this->json($this->model->getAll());
    }

    public function show($id)
    {
        $menu = $this->model->getById((int) $id);
        if (!$menu) {
            $this->json(['error' => 'Combo menu not found'], 404);
            return;
        }
        $this->json($menu);
    }

    public function store()
    {
        Auth::requireAuth();
        Csrf::validate();

        $input = json_decode(file_get_contents('php://input'), true);
        $errors = $this->validateMenu($input);
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

        $menu = $this->model->getById((int) $id);
        if (!$menu) {
            $this->json(['error' => 'Combo menu not found'], 404);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $errors = $this->validateMenu($input);
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

        $menu = $this->model->getById((int) $id);
        if (!$menu) {
            $this->json(['error' => 'Combo menu not found'], 404);
            return;
        }

        $this->model->delete((int) $id);
        $this->json(['success' => true]);
    }

    // --- Items ---

    public function addItem($menuId)
    {
        Auth::requireAuth();
        Csrf::validate();

        $menu = $this->model->getById((int) $menuId);
        if (!$menu) {
            $this->json(['error' => 'Combo menu not found'], 404);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $errors = $this->validateItem($input);
        if ($errors) {
            $this->json(['errors' => $errors], 422);
            return;
        }

        $itemId = $this->model->addItem((int) $menuId, $input);
        $this->json($this->model->getById((int) $menuId), 201);
    }

    public function updateItem($menuId, $itemId)
    {
        Auth::requireAuth();
        Csrf::validate();

        $input = json_decode(file_get_contents('php://input'), true);
        $errors = $this->validateItem($input);
        if ($errors) {
            $this->json(['errors' => $errors], 422);
            return;
        }

        $this->model->updateItem((int) $menuId, (int) $itemId, $input);
        $this->json($this->model->getById((int) $menuId));
    }

    public function deleteItem($menuId, $itemId)
    {
        Auth::requireAuth();
        Csrf::validate();

        $this->model->deleteItem((int) $menuId, (int) $itemId);
        $this->json(['success' => true]);
    }

    private function validateMenu($input)
    {
        $errors = [];
        if (empty($input['name'])) {
            $errors[] = 'name is required';
        }
        if (empty($input['nameCro'])) {
            $errors[] = 'nameCro is required';
        }
        if (empty($input['nameEn'])) {
            $errors[] = 'nameEn is required';
        }
        if (empty($input['personCount']) || !is_numeric($input['personCount'])) {
            $errors[] = 'personCount must be a number';
        }
        if (!isset($input['price']) || !is_numeric($input['price'])) {
            $errors[] = 'price must be a number';
        } elseif ((float) $input['price'] < 0) {
            $errors[] = 'price cannot be negative';
        }
        return $errors;
    }

    private function validateItem($input)
    {
        $errors = [];
        if (!isset($input['itemNumber']) || !is_numeric($input['itemNumber'])) {
            $errors[] = 'itemNumber is required';
        }
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
