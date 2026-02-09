<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Dish;
use App\Models\ComboMenu;
use PDO;

class PageController
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function home()
    {
        $activePage = 'home';
        $pageTitle = 'Kineski restoran Peking - Zagreb';
        $this->render('home', compact('activePage', 'pageTitle'));
    }

    public function about()
    {
        $activePage = 'about';
        $pageTitle = 'O nama - Kineski restoran Peking';
        $this->render('about', compact('activePage', 'pageTitle'));
    }

    public function menu()
    {
        $activePage = 'menu';
        $categoryModel = new Category($this->pdo);
        $categories = $categoryModel->getAll();

        $comboModel = new ComboMenu($this->pdo);
        $comboMenus = $comboModel->getAll();

        // Group combos by personCount
        $comboGroups = [];
        foreach ($comboMenus as $combo) {
            $comboGroups[$combo['personCount']][] = $combo;
        }

        $pageTitle = 'Jelovnik - Kineski restoran Peking';
        $this->render('menu', compact('activePage', 'pageTitle', 'categories', 'comboGroups'));
    }

    public function menuCategory($id)
    {
        $activePage = 'menu';
        $categoryModel = new Category($this->pdo);
        $category = $categoryModel->getById((int) $id);

        if (!$category) {
            http_response_code(404);
            echo '<h1>Category not found</h1>';
            return;
        }

        $dishModel = new Dish($this->pdo);
        $dishes = $dishModel->getAll((int) $id);

        // For sidebar
        $categories = $categoryModel->getAll();
        $comboModel = new ComboMenu($this->pdo);
        $comboMenus = $comboModel->getAll();
        $comboGroups = [];
        foreach ($comboMenus as $combo) {
            $comboGroups[$combo['personCount']][] = $combo;
        }

        $pageTitle = htmlspecialchars($category['nameCro']) . ' - Jelovnik - Kineski restoran Peking';
        $this->render('menuCategory', compact('activePage', 'pageTitle', 'category', 'dishes', 'categories', 'comboGroups'));
    }

    public function comboMenu($personCount)
    {
        $activePage = 'menu';
        $comboModel = new ComboMenu($this->pdo);
        $menus = $comboModel->getByPersonCount((int) $personCount);

        // For sidebar
        $categoryModel = new Category($this->pdo);
        $categories = $categoryModel->getAll();
        $comboMenus = $comboModel->getAll();
        $comboGroups = [];
        foreach ($comboMenus as $combo) {
            $comboGroups[$combo['personCount']][] = $combo;
        }

        $pageTitle = 'Menu za ' . (int) $personCount . ' osobe - Kineski restoran Peking';
        $this->render('comboMenu', compact('activePage', 'pageTitle', 'menus', 'personCount', 'categories', 'comboGroups'));
    }

    public function contact()
    {
        $activePage = 'contact';
        $pageTitle = 'Kontakt - Kineski restoran Peking';
        $this->render('contact', compact('activePage', 'pageTitle'));
    }

    private function render($view, $data = [])
    {
        extract($data);
        require APP_ROOT . '/Views/layout/header.php';
        require APP_ROOT . '/Views/pages/' . $view . '.php';
        require APP_ROOT . '/Views/layout/footer.php';
    }
}
