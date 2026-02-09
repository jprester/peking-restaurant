<?php
/**
 * Migration script: imports data from the old peking database into the new schema.
 *
 * Usage: php migrate.php
 *
 * Prerequisites:
 *   - Old database "peking" with tables: meni, jela, user
 *   - New schema will be created in the same database (old tables are untouched)
 */

$appConfig = require __DIR__ . '/../app/config.php';
$config = $appConfig['db'];

$port = isset($config['port']) ? ";port={$config['port']}" : '';
$dsn = "mysql:host={$config['host']}{$port};dbname={$config['name']};charset={$config['charset']}";
$pdo = new PDO($dsn, $config['user'], $config['pass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

echo "=== Peking CMS Migration ===\n\n";

// 1. Run new schema
echo "Creating new tables...\n";

// Check if old tables exist, if not, try to import them from the legacy SQL dump
$stmt = $pdo->query("SHOW TABLES LIKE 'meni'");
if ($stmt->rowCount() === 0) {
    echo "Old tables not found. Importing legacy data from src/admin/database/pekingco_data.sql...\n";
    $oldSqlPath = __DIR__ . '/../src/admin/database/pekingco_data.sql';
    if (file_exists($oldSqlPath)) {
        $oldSql = file_get_contents($oldSqlPath);
        // The old dump might have multiple statements, pdo->exec works but can be tricky with large files.
        // For simplicity in this script, we'll try to exec it. 
        // Note: Some dumps have SET commands that might fail depending on permissions, but usually okay in MAMP.
        try {
            $pdo->exec($oldSql);
            echo "  Legacy data imported.\n";
        } catch (Exception $e) {
            echo "  Warning: Error importing legacy data: " . $e->getMessage() . "\n";
            echo "  Make sure you have imported the old database tables (meni, jela) manually if this fails.\n";
        }
    } else {
        echo "  Warning: Legacy SQL dump not found at $oldSqlPath\n";
    }
}

$schema = file_get_contents(__DIR__ . '/schema.sql');
$pdo->exec($schema);
echo "  Done.\n\n";

// 2. Migrate categories from old `meni` table
echo "Migrating categories...\n";
$oldCategories = $pdo->query("SELECT mid, meni_ime, en_ime FROM meni ORDER BY mid")->fetchAll();
$categoryMap = []; // old mid => new id

$insertCategory = $pdo->prepare(
    "INSERT INTO categories (nameCro, nameEn, sortOrder) VALUES (:nameCro, :nameEn, :sortOrder)"
);

foreach ($oldCategories as $i => $cat) {
    $insertCategory->execute([
        ':nameCro' => trim($cat['meni_ime']),
        ':nameEn' => trim($cat['en_ime']),
        ':sortOrder' => $i + 1,
    ]);
    $categoryMap[$cat['mid']] = $pdo->lastInsertId();
}
echo "  Migrated " . count($oldCategories) . " categories.\n\n";

// 3. Migrate dishes from old `jela` table
echo "Migrating dishes...\n";
$oldDishes = $pdo->query("SELECT * FROM jela ORDER BY mid, sort")->fetchAll();

$insertDish = $pdo->prepare(
    "INSERT INTO dishes (categoryId, dishNumber, nameCro, nameEn, price, sortOrder)
     VALUES (:categoryId, :dishNumber, :nameCro, :nameEn, :price, :sortOrder)"
);

$dishCount = 0;
foreach ($oldDishes as $dish) {
    $newCategoryId = $categoryMap[$dish['mid']] ?? null;
    if ($newCategoryId === null) {
        echo "  WARNING: Dish '{$dish['naziv']}' has unknown category mid={$dish['mid']}, skipping.\n";
        continue;
    }

    // Convert price from "45,00" format to decimal
    $price = str_replace(',', '.', trim($dish['cijena']));
    $price = (float) $price;

    $insertDish->execute([
        ':categoryId' => $newCategoryId,
        ':dishNumber' => trim($dish['broj']),
        ':nameCro' => trim($dish['naziv']),
        ':nameEn' => trim($dish['naziv_en']),
        ':price' => $price,
        ':sortOrder' => (int) $dish['sort'],
    ]);
    $dishCount++;
}
echo "  Migrated {$dishCount} dishes.\n\n";

// 4. Insert combo menus (extracted from hardcoded PHP files)
echo "Creating combo menus...\n";

$comboMenus = [
    [
        'name' => 'Menu P1',
        'nameCro' => 'Menu za 2 osobe (P1)',
        'nameEn' => 'Menu for 2 people (P1)',
        'personCount' => 2,
        'price' => 45.00,
        'sortOrder' => 1,
        'items' => [
            ['nameCro' => 'Kiselo - ljuta juha', 'nameEn' => 'Hot and sour soup'],
            ['nameCro' => 'Proljetne rolade', 'nameEn' => 'Spring rolls'],
            ['nameCro' => 'Piletina "Gombao" (ljuto)', 'nameEn' => 'Chicken "Gombao" style (hot)'],
            ['nameCro' => 'Junetina s bambusom i kineskim gljivama', 'nameEn' => 'Beef with bamboo and chinese mushrooms'],
            ['nameCro' => 'Riža', 'nameEn' => 'Rice'],
            ['nameCro' => 'Pohane banane', 'nameEn' => 'Fried bananas'],
        ],
    ],
    [
        'name' => 'Menu P2',
        'nameCro' => 'Menu za 2 osobe (P2)',
        'nameEn' => 'Menu for 2 people (P2)',
        'personCount' => 2,
        'price' => 51.00,
        'sortOrder' => 2,
        'items' => [
            ['nameCro' => 'Kiselo - ljuta juha', 'nameEn' => 'Hot and sour soup'],
            ['nameCro' => 'Proljetne rolade', 'nameEn' => 'Spring rolls'],
            ['nameCro' => 'Hrskava patka sa slatko-kiselim umakom', 'nameEn' => 'Crispy deep fried duck with sweet and sour sauce'],
            ['nameCro' => 'Piletina sa povrćem', 'nameEn' => 'Chicken with vegetables'],
            ['nameCro' => 'Riža', 'nameEn' => 'Rice'],
            ['nameCro' => 'Pohani sladoled', 'nameEn' => 'Fried ice cream'],
        ],
    ],
    [
        'name' => 'Menu P3',
        'nameCro' => 'Menu za 3 osobe (P3)',
        'nameEn' => 'Menu for 3 people (P3)',
        'personCount' => 3,
        'price' => 73.00,
        'sortOrder' => 3,
        'items' => [
            ['nameCro' => 'Kiselo - ljuta juha', 'nameEn' => 'Hot and sour soup'],
            ['nameCro' => 'Proljetne rolade', 'nameEn' => 'Spring rolls'],
            ['nameCro' => 'Junetina "Szechuan"', 'nameEn' => 'Beef "Szechuan" style (hot)'],
            ['nameCro' => 'Svinjetina s bambusom i kineskim gljivama', 'nameEn' => 'Pork with bamboo and chinese mushrooms'],
            ['nameCro' => 'Hrskava patka sa slatko-kiselim umakom', 'nameEn' => 'Crispy deep fried duck with sweet and sour sauce'],
            ['nameCro' => 'Riža', 'nameEn' => 'Rice'],
            ['nameCro' => 'Pohane banane', 'nameEn' => 'Fried bananas'],
        ],
    ],
    [
        'name' => 'Menu P4',
        'nameCro' => 'Menu za 3 osobe (P4)',
        'nameEn' => 'Menu for 3 people (P4)',
        'personCount' => 3,
        'price' => 70.00,
        'sortOrder' => 4,
        'items' => [
            ['nameCro' => 'Kiselo - ljuta juha', 'nameEn' => 'Hot and sour soup'],
            ['nameCro' => 'Proljetne rolade', 'nameEn' => 'Spring rolls'],
            ['nameCro' => 'Hrskava piletina sa slatko-kiselim umakom', 'nameEn' => 'Crispy deep fried chicken with sweet and sour sauce'],
            ['nameCro' => 'Junetina s bambusom i kineskim gljivama', 'nameEn' => 'Beef with bamboo and chinese mushrooms'],
            ['nameCro' => 'Riba u slatko-kiselom umaku', 'nameEn' => 'Fish in sweet and sour sauce'],
            ['nameCro' => 'Riža', 'nameEn' => 'Rice'],
            ['nameCro' => 'Pohani sladoled', 'nameEn' => 'Fried ice cream'],
        ],
    ],
    [
        'name' => 'Menu P5',
        'nameCro' => 'Menu za 4 osobe (P5)',
        'nameEn' => 'Menu for 4 people (P5)',
        'personCount' => 4,
        'price' => 94.00,
        'sortOrder' => 5,
        'items' => [
            ['nameCro' => 'Kiselo - ljuta juha', 'nameEn' => 'Hot and sour soup'],
            ['nameCro' => 'Proljetne rolade', 'nameEn' => 'Spring rolls'],
            ['nameCro' => 'Piletina "Gombao" (ljuto)', 'nameEn' => 'Chicken "Gombao" style (hot)'],
            ['nameCro' => 'Junetina s bambusom i kineskim gljivama', 'nameEn' => 'Beef with bamboo and chinese mushrooms'],
            ['nameCro' => 'Svinjetina s povrćem', 'nameEn' => 'Pork with vegetables'],
            ['nameCro' => 'Hrskava patka sa slatko-kiselim umakom', 'nameEn' => 'Crispy fried duck with sweet and sour sauce'],
            ['nameCro' => 'Riža', 'nameEn' => 'Rice'],
            ['nameCro' => 'Pohane banane', 'nameEn' => 'Fried bananas'],
        ],
    ],
    [
        'name' => 'Menu P6',
        'nameCro' => 'Menu za 4 osobe (P6)',
        'nameEn' => 'Menu for 4 people (P6)',
        'personCount' => 4,
        'price' => 97.00,
        'sortOrder' => 6,
        'items' => [
            ['nameCro' => 'Kiselo - ljuta juha', 'nameEn' => 'Hot and sour soup'],
            ['nameCro' => 'Proljetne rolade', 'nameEn' => 'Spring rolls'],
            ['nameCro' => 'Hrskava patka sa slatko-kiselim umakom', 'nameEn' => 'Crispy fried duck with sweet and sour sauce'],
            ['nameCro' => 'Piletina s bambusom i kineskim gljivama', 'nameEn' => 'Chicken with bamboo and chinese mushrooms'],
            ['nameCro' => 'Junetina "Szechuan" (Ljuto)', 'nameEn' => 'Beef "Szechuan" style (hot)'],
            ['nameCro' => 'Pohana svinjetina u kiselo - slatkom umaku', 'nameEn' => 'Fried pork in sweet and sour sauce'],
            ['nameCro' => 'Riža', 'nameEn' => 'Rice'],
            ['nameCro' => 'Pohani sladoled', 'nameEn' => 'Fried ice cream'],
        ],
    ],
];

$insertCombo = $pdo->prepare(
    "INSERT INTO comboMenus (name, nameCro, nameEn, personCount, price, sortOrder)
     VALUES (:name, :nameCro, :nameEn, :personCount, :price, :sortOrder)"
);

$insertComboItem = $pdo->prepare(
    "INSERT INTO comboMenuItems (comboMenuId, itemNumber, nameCro, nameEn, sortOrder)
     VALUES (:comboMenuId, :itemNumber, :nameCro, :nameEn, :sortOrder)"
);

foreach ($comboMenus as $combo) {
    $insertCombo->execute([
        ':name' => $combo['name'],
        ':nameCro' => $combo['nameCro'],
        ':nameEn' => $combo['nameEn'],
        ':personCount' => $combo['personCount'],
        ':price' => $combo['price'],
        ':sortOrder' => $combo['sortOrder'],
    ]);
    $comboId = $pdo->lastInsertId();

    foreach ($combo['items'] as $i => $item) {
        $insertComboItem->execute([
            ':comboMenuId' => $comboId,
            ':itemNumber' => $i + 1,
            ':nameCro' => $item['nameCro'],
            ':nameEn' => $item['nameEn'],
            ':sortOrder' => $i + 1,
        ]);
    }
}
echo "  Created " . count($comboMenus) . " combo menus.\n\n";

// 5. Create admin user with bcrypt password
echo "Creating admin user...\n";
$adminPassword = 'admin123'; // Change this after first login!
$hash = password_hash($adminPassword, PASSWORD_BCRYPT);

$insertUser = $pdo->prepare(
    "INSERT INTO users (username, passwordHash) VALUES (:username, :passwordHash)"
);
$insertUser->execute([
    ':username' => 'admin',
    ':passwordHash' => $hash,
]);
echo "  Created user 'admin' with password 'admin123' (CHANGE THIS IMMEDIATELY)\n\n";

// Summary
$catCount = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
$dishCount = $pdo->query("SELECT COUNT(*) FROM dishes")->fetchColumn();
$comboCount = $pdo->query("SELECT COUNT(*) FROM comboMenus")->fetchColumn();
$comboItemCount = $pdo->query("SELECT COUNT(*) FROM comboMenuItems")->fetchColumn();

echo "=== Migration Complete ===\n";
echo "  Categories:      {$catCount}\n";
echo "  Dishes:           {$dishCount}\n";
echo "  Combo menus:      {$comboCount}\n";
echo "  Combo menu items: {$comboItemCount}\n";
echo "  Admin user:       admin / admin123\n";
echo "\nIMPORTANT: Change the admin password after first login!\n";
