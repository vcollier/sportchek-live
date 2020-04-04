<?php
require_once 'load.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $tbl = 'tbl_product';
    $col = 'product_id';
    $getProduct = getSingleProduct($tbl, $col, $id);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Details</title>
</head>
<body>
    <?php if(!is_string($getProduct)):?>
        <?php while($row = $getProduct->fetch(PDO::FETCH_ASSOC)):?>
            <img src="images/<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name'] ?>" />

            <h2><?php echo $row['product_name'];?></h2>
            <h4>$<?php echo $row['product_price'];?></h4>
            <p><br> <?php echo $row['product_desc'];?></p>
            <a href="index.php">Back...</a>
        <?php endwhile;?>
    <?php endif;?>
</body>
</html>