<?php

require_once('../controllers/ProductController.php');

$productController = new ProductController($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['action'] === 'getAllProducts') {
        $productos = $productController->getAllProducts();
        echo json_encode($productos);
    } elseif ($_GET['action'] === 'getProductById') {
        $id = $_GET['id'];
        $producto = $productController->getProductById($id);
        echo json_encode($producto);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_GET['action'] === 'createProduct') {

        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $amount = $_POST['amount'];


        $productId = $productController->createProduct($name, $description, $price, $amount);


        echo json_encode(['productId' => $productId]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    if ($_GET['action'] === 'updateProduct') {

        parse_str(file_get_contents("php://input"), $requestData);
        $id = $requestData['id'];
        $name = $requestData['name'];
        $description = $requestData['description'];
        $price = $requestData['price'];
        $amount = $requestData['amount'];


        $rowCount = $productController->updateProduct($id, $name, $description, $price, $amount);


        echo json_encode(['rowCount' => $rowCount]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if ($_GET['action'] === 'deleteProduct') {

        $id = $_GET['id'];


        $rowCount = $productController->deleteProduct($id);


        echo json_encode(['rowCount' => $rowCount]);
    }
}
?>