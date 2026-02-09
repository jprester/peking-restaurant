<?php

require_once __DIR__ . '/../app/bootstrap.php';

use App\Router;
use App\Controllers\Api\AuthController;
use App\Controllers\Api\CategoryController;
use App\Controllers\Api\DishController;
use App\Controllers\Api\ComboMenuController;
use App\Controllers\PageController;

$router = new Router();
$router->setDebug($config['app']['debug']);
$pdo = $db->getPdo();

// --- API Routes ---

// Auth
$router->get('/api/auth/me', function() use($pdo) { return (new AuthController($pdo))->me(); });
$router->post('/api/auth/login', function() use($pdo) { return (new AuthController($pdo))->login(); });
$router->post('/api/auth/logout', function() use($pdo) { return (new AuthController($pdo))->logout(); });
$router->post('/api/auth/change-password', function() use($pdo) { return (new AuthController($pdo))->changePassword(); });

// Categories
$router->get('/api/categories', function() use($pdo) { return (new CategoryController($pdo))->index(); });
$router->get('/api/categories/{id}', function($id) use($pdo) { return (new CategoryController($pdo))->show($id); });
$router->post('/api/categories', function() use($pdo) { return (new CategoryController($pdo))->store(); });
$router->post('/api/categories/reorder', function() use($pdo) { return (new CategoryController($pdo))->reorder(); });
$router->put('/api/categories/{id}', function($id) use($pdo) { return (new CategoryController($pdo))->update($id); });
$router->delete('/api/categories/{id}', function($id) use($pdo) { return (new CategoryController($pdo))->destroy($id); });

// Dishes
$router->get('/api/dishes', function() use($pdo) { return (new DishController($pdo))->index(); });
$router->get('/api/dishes/{id}', function($id) use($pdo) { return (new DishController($pdo))->show($id); });
$router->post('/api/dishes', function() use($pdo) { return (new DishController($pdo))->store(); });
$router->post('/api/dishes/reorder', function() use($pdo) { return (new DishController($pdo))->reorder(); });
$router->put('/api/dishes/{id}', function($id) use($pdo) { return (new DishController($pdo))->update($id); });
$router->delete('/api/dishes/{id}', function($id) use($pdo) { return (new DishController($pdo))->destroy($id); });

// Combo Menus
$router->get('/api/comboMenus', function() use($pdo) { return (new ComboMenuController($pdo))->index(); });
$router->get('/api/comboMenus/{id}', function($id) use($pdo) { return (new ComboMenuController($pdo))->show($id); });
$router->post('/api/comboMenus', function() use($pdo) { return (new ComboMenuController($pdo))->store(); });
$router->put('/api/comboMenus/{id}', function($id) use($pdo) { return (new ComboMenuController($pdo))->update($id); });
$router->delete('/api/comboMenus/{id}', function($id) use($pdo) { return (new ComboMenuController($pdo))->destroy($id); });
$router->post('/api/comboMenus/{id}/items', function($id) use($pdo) { return (new ComboMenuController($pdo))->addItem($id); });
$router->put('/api/comboMenus/{id}/items/{itemId}', function($id, $itemId) use($pdo) { return (new ComboMenuController($pdo))->updateItem($id, $itemId); });
$router->delete('/api/comboMenus/{id}/items/{itemId}', function($id, $itemId) use($pdo) { return (new ComboMenuController($pdo))->deleteItem($id, $itemId); });

// --- Page Routes ---
$page = new PageController($pdo);

$router->get('/', function() use($page) { return $page->home(); });
$router->get('/about', function() use($page) { return $page->about(); });
$router->get('/menu', function() use($page) { return $page->menu(); });
$router->get('/menu/combo/{personCount}', function($pc) use($page) { return $page->comboMenu($pc); });
$router->get('/menu/{id}', function($id) use($page) { return $page->menuCategory($id); });
$router->get('/contact', function() use($page) { return $page->contact(); });

// Resolve the current request
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

try {
    $router->resolve($method, $uri);
} catch (Exception $e) {
    if (strpos($uri, '/api/') === 0) {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
    } else {
        http_response_code(500);
        echo '<h1>500 - Internal Server Error</h1>';
        if ($config['app']['debug']) {
            echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
        }
    }
}
