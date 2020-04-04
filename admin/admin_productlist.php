<?php
    require_once '../load.php';
    confirm_logged_in();

    $products = getAllProducts();
    if(!$products){
        $message = 'Failed to get  list';
    }

    if(isset($_GET['id'])){
        $product_id = $_GET['id'];
        $edit_result - editProduct($product_id);

        if(!$edit_result){
            $message = 'Failed to edit product';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <h2>Edit Products</h2>
    <?php echo !empty($message)?$message:'';?>
<table>
<thread>
<tr>
<th>Product ID</th>
<th>Product Name</th>
<th>Product Price</th>
<th>Edit</th>
</tr>
</thread>

<tbody>
<?php while($product = $products->fetch(PDO::FETCH_ASSOC)):?>
<tr>
<td><?php echo $product['product_id'];?></td>
<td><?php echo $product['product_name'];?></td>
<td><?php echo $product['product_price'];?></td>
<td><a href="admin_editproduct.php?id=<?php echo $product['product_id'];?>">Edit</a></td>
</tr>
<?php endwhile;?>
</table>

    
</body>
</html>