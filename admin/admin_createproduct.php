<?php
require_once '../load.php';
confirm_logged_in();

$category = 'tbl_category';
    $categories      = getAll($category);


    if(isset($_POST['submit'])){
        $product_name = trim($_POST['name']);
        $product_desc = trim($_POST['desc']);
        $product_price = trim($_POST['price']);
        $product_cat = $_POST['category'];
        $product_image = $_FILES['image'];

    if(empty($product_name) || empty($product_desc) || empty($product_price) || empty($product_image) || empty($product_cat)){
        $message = 'Please fill the required fields';
    }else{
        $message = createProduct($product_name, $product_desc, $product_price, $product_cat, $product_image);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Product</title>
</head>
<body>
    <h2>Create Product</h2>
    <?php echo !empty($message)? $message: ''; ?>
    <form action="admin_createproduct.php" enctype="multipart/form-data" method="post" >
    <label>Product Name</label>
    <input type="text" name="name" value=""><br><br>
    <label>Product Description</label>
    <input type="text" name="desc" value=""><br><br>
    <label>Product Price</label>
    <input type="number" id="price" name="price" min="1" step="any"><br><br>
    <label for="category">Category</label>
        <select name="category" id="category" required>
        <option>Please select a product catagory...</option>
        <?php while($row = $categories->fetch(PDO::FETCH_ASSOC)): ?>
        <option value="<?php echo $row['category_id'] ?>"><?php echo $row['category_name'];?></option>

        <?php endwhile;?>
        </select><br> <br>
    <label>Product Image</label>
    <input type="file" name="image" value=""><br><br>
    <button name="submit">Create pro</button>
    </form>
</body>
</html>