<?php
require_once 'load.php';

if(isset($_GET['filter'])){
    //Filter
    $args = array(
        'tbl'=>'tbl_product',
        'tbl2'=>'tbl_category',
        'tbl3'=>'tbl_category_product',
        'col'=>'product_id',
        'col2'=>'category_id',
        'col3'=>'category_name',
        'filter'=>$_GET['filter']
    );
    $getProducts = getProductsByFilter($args);
}else{
    $product_table = 'tbl_product';
    $getProducts = getAll($product_table);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/reset.css" rel="stylesheet" type="text/css">
	<link href="css/main.css" rel="stylesheet" type="text/css">
    <title>SportChek</title>
</head>


<body>
    <?php include 'templates/header.php';?>
    <div class="items-section">
    <?php while($row = $getProducts->fetch(PDO::FETCH_ASSOC)):?>
        
      <div class="product-item">
            <img class="product-image" src="images/<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name'];?>">
            <h2><?php echo $row ['product_name'];?></h2>
            <h4>$<?php echo $row ['product_price'];?></h4>
            <a href="details.php?id=<?php echo $row['product_id'];?>">Read More...</a>
        </div>
    <?php endwhile;?>    
    </div>
</body>
</html>