<?php
require_once('config/config.php');
require_once('models/ProductModel.php');

$db = getDBConnection();
$productModel = new ProductModel($db);

$productos = $productModel->getAllProducts();

$action = $_GET['action'] ?? '';


switch ($action) {
    case 'create':

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $amount = $_POST['amount'];
            $price = number_format($price, 2, '.', '');
            $newProductId = $productModel->createProduct($name, $description, $price, $amount);
            echo "ID del nuevo producto creado: " . $newProductId . "<br>";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {

            echo 'Formulario para crear un producto<br>';
            echo '<form method="POST" action="?action=create">';
            echo 'Nombre: <input type="text" name="name"><br>';
            echo 'Descripción: <input type="text" name="description"><br>';
            echo 'Precio: <input type="text" name="price"><br>';
            echo 'Cantidad: <input type="number" name="amount"><br>';
            echo '<input type="submit" value="Crear">';
            echo '</form>';
        }
        break;

    case 'read':
        $productos = $productModel->getAllProducts();
        echo '<h1>Lista de Productos</h1>';
        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Nombre</th>';
        echo '<th>Descripción</th>';
        echo '<th>Precio</th>';
        echo '<th>Cantidad</th>';
        echo '<th>Acciones</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach ($productos as $producto) {
            echo '<tr>';
            echo '<td>' . $producto['id'] . '</td>';
            echo '<td>' . $producto['name'] . '</td>';
            echo '<td>' . $producto['description'] . '</td>';
            echo '<td>' . $producto['price'] . '</td>';
            echo '<td>' . $producto['amount'] . '</td>';
            echo '<td>';
            echo '<a href="?action=update&id=' . $producto['id'] . '">Editar</a>';
            echo '<a href="?action=delete&id=' . $producto['id'] . '">Eliminar</a>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        break;

    case 'update':

        $productId = $_GET['id'] ?? null;
        if ($productId === null) {
            echo 'ID del producto no especificado.';
        } else {

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = $_POST['name'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $amount = $_POST['amount'];
                $rowCount = $productModel->updateProduct($productId, $name, $description, $price, $amount);
                echo 'Producto actualizado. Filas afectadas: ' . $rowCount . '<br>';
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            } else {

                $product = $productModel->getProductById($productId);
                if ($product) {
                    echo 'Formulario para actualizar el producto:<br>';
                    echo '<form method="POST" action="?action=update&id=' . $productId . '">';
                    echo 'Nombre: <input type="text" name="name" value="' . $product['name'] . '"><br>';
                    echo 'Descripción: <input type="text" name="description" value="' . $product['description'] . '"><br>';
                    echo 'Precio: <input type="number" name="price" value="' . $product['price'] . '"><br>';
                    echo 'Cantidad: <input type="number" name="amount" value="' . $product['amount'] . '"><br>';
                    echo '<input type="submit" value="Actualizar">';
                    echo '</form>';
                } else {
                    echo 'Producto no encontrado.';
                }
            }
        }
        break;

    case 'delete':

        $productId = $_GET['id'] ?? null;
        if ($productId === null) {
            echo 'ID del producto no especificado.';
        } else {

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $rowCount = $productModel->deleteProduct($productId);
                echo 'Producto eliminado. Filas afectadas: ' . $rowCount . '<br>';
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            } else {

                $product = $productModel->getProductById($productId);
                if ($product) {
                    echo '¿Estás seguro de que deseas eliminar el producto "' . $product['name'] . '"?<br>';
                    echo '<form method="POST" action="?action=delete&id=' . $productId . '">';
                    echo '<input type="submit" value="Eliminar">';
                    echo '</form>';
                } else {
                    echo 'Producto no encontrado.';
                }
            }
        }
        break;

    default:
        echo '';
}
?>


<!DOCTYPE html>
<html>

<body>

<a href="?action=create">Agregar Producto</a>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td>
                        <?php echo $producto['id']; ?>
                    </td>
                    <td>
                        <?php echo $producto['name']; ?>
                    </td>
                    <td>
                        <?php echo $producto['description']; ?>
                    </td>
                    <td>
                        <?php echo $producto['price']; ?>
                    </td>
                    <td>
                        <?php echo $producto['amount']; ?>
                    </td>
                    <td>
                        <a href="?action=update&id=<?php echo $producto['id']; ?>">Editar</a>
                        <a href="?action=delete&id=<?php echo $producto['id']; ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>