<?php

namespace Migrate;

require_once 'vendor/autoload.php';

use function Functional\map;

include 'Database.php';

include "lib/database/Mapper.php";
include 'lib/database/Definition.php';
include 'lib/database/Mapping.php';
include 'lib/database/Property.php';

header('Content-Type: application/json');

$db = new DatabaseMap();

if (isset($_GET['products'])) {
    $products = $db->productsMapper()->findAll();
    echo json_encode($products);
} else if (isset($_GET['categories'])) {
    $categories = $db->categoriesMapper()->findAll();
    $categories = map($categories, function ($category) {
       
        $description = $category['description'];
        unset($category['description']);

        return array_merge($category, $description);
    });
    $categories = map($categories, function($category){
        if(!$category['parent_id'] == 0) {
            $display = 'subcategories';
        } else {
            $display = 'default';
        }

        return [
            'id' => $category['categories_id'],
            'parent' => $category['parent_id'],
            'menu_order' => $category['sort_order'],
            'name' => $category['categories_name'],
            'description' => $category['categories_description'],
            'display' => $display
        ];
    });
    echo json_encode($categories);
} else {
    echo json_encode(['error', 'URL Param Not Specified']);
}
