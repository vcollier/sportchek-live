<?php
    require_once '../load.php';
    confirm_logged_in();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../css/reset.css" rel="stylesheet" type="text/css">
	<link href="../css/main.css" rel="stylesheet" type="text/css">
    <title>Dashboard</title>
</head>
<body>
<?php include '../templates/header-admin.php';?>
    <h2 class="admin-welcome">Welcome! <?php echo $_SESSION['user_name'];?></h2>

    <a href="admin_logout.php" class="admin-nav">Sign Out</a>
    <div class="product-div">
        <h4>Products</h4>
    <a href="admin_createproduct.php" class="admin-nav">Create New Product</a>
    <a href="admin_productlist.php" class="admin-nav">Edit A Product</a>
    <a href="admin_deleteproduct.php" class="admin-nav">Delete Product</a>
    </div>
    <div class="user-div">
    <h4>Users</h4>
    <a href="admin_createuser.php" class="admin-nav">Create User</a>
    </div>
</body>
</html>