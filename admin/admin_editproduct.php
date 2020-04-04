<?php 
    require_once '../load.php';
    confirm_logged_in();

    $category = 'tbl_category';
    $categories      = getAll($category);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $tbl = 'tbl_product';
        $col = 'product_id';
        $getProduct = getSingleProduct($tbl, $col, $id);
    }

    
    if(isset($_POST['submit'])){
        $name = trim($_POST['name']);
        $desc = trim($_POST['desc']);
        $image = $_FILES['image'];
        $category = $_POST['category'];
        $price = trim($_POST['price']);
        
        if(empty($name) || empty($desc) || empty($price) || empty($category)){
            $message = 'Please fill the required fields';
    
            }else{ 
                $result = editProduct($id, $name, $desc, $price, $category, $image);
            }
            $message = $result;
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

<h1>Edit Product</h1>

<?php echo !empty($message)? $message : '';?>
    <form action="admin_editproduct.php?id=<?php echo $id ; ?>" method="post" enctype='multipart/form-data'>
        <?php while($info = $getProduct->fetch(PDO::FETCH_ASSOC)): ?>

            <label>Product Name:</label><br>
            <input type="text" name="name" value="<?php echo $info['product_name'];?>"><br><br>

            <label>Price:</label><br>
            <input type="text" name="price" value="<?php echo $info['product_price'];?>"><br><br>

            <label>Product Image:</label><br>
            <input type="file" name="image" value="<?php echo $info['product_image'];?>"><br><br>

            <label>Description:</label><br>
            <textarea type="text" name="desc"><?php echo $info['product_desc'];?></textarea> <br><br>

            <label for="category">Category</label>
        <select name="category" id="category" required>
        <option>Please select a product catagory...</option>
        <?php while($row = $categories->fetch(PDO::FETCH_ASSOC)): ?>
        <option value="<?php echo $row['category_id'] ?>"><?php echo $row['category_name'];?></option>

        <?php endwhile;?>
        </select><br> <br>
            
        <?php endwhile;?>
        <button type="submit" name="submit">Edit Product</button>
    </form>

    <a href="index.php">Back Home...</a>

</body>
</html>