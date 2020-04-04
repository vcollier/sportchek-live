<?php
// function createProduct ($name, $desc, $price, $image){
//     $pdo = Database::getInstance()->getConnection();
    
//     //TODO: finish the below so that it can run a SQL query
//     // to create a new user with provided data

//     $create_product_query = 'INSERT INTO tbl_product(product_name, product_desc, product_price, product_image) VALUES (:name, :desc, :price, :image)';
    

//     $create_product_set = $pdo->prepare($create_product_query);
//     $create_product_result = $create_product_set->execute(
//         array(
//             ':name'=>$name,
//             ':desc'=>$desc,
//             ':price'=>$price,
//             ':image'=>$image,
//         )
//     );
//     //TODO: redirect to index.php if creat user successfully
//     // otherwise, return
//     if($create_product_set){
//         redirect_to('index.php');
//     }else{
//         return 'The product did not go through';
//     }

// }


function getAllProducts(){
    $pdo = Database::getInstance()->getConnection();

    $get_product_query = 'SELECT * FROM tbl_product';
    $products = $pdo->query($get_product_query);

    if($products) {
        return $products;
    }else{
        return false;
    }
}

function getOneProduct($id){
    $pdo = Database::getInstance()->getConnection();
    //TODO: execute the proper SQL query to fetch the user data
    $get_product_query = 'SELECT * FROM tbl_product WHERE product_id = :id';
    $get_product_set = $pdo->prepare($get_product_query);
    $get_product_result = $get_product_set->execute(
        array(
            ':id' =>$id
        )
    );
        //TODO: if the execution is successful, return the user data
        // Otherwise, return an error message
    if($get_product_result){
        return $get_product_set;
    }else{
        return 'There was a problem accessing the product';
    }
}

function editProduct($id, $name, $desc, $price, $category, $image){

    try {
        $pdo = Database::getInstance()->getConnection();
        //validate the file, must be image
        $file_type      = pathinfo($image['name'], PATHINFO_EXTENSION);
        $accepted_types = array('gif', 'jpg', 'jpe', 'jpeg', 'png');
        if (!in_array($file_type, $accepted_types)) { //if not the right extentions
            throw new Exception('Wrong file type!');
        }

        //take the temporary file and store it
        $new_name = uniqid() . '.' .  $file_type;
        $target_path = '../images/' . $new_name;
        if (!move_uploaded_file($image['tmp_name'], $target_path)) {
            throw new Exception('Failed to move uploaded file!');
        }
    
        //TODO: set up database connection
        $pdo = Database::getInstance()->getConnection();

        //TODO: Run the proper SQL query to update tbl_user with proper values
        $update_product_query = 'UPDATE tbl_product SET product_name = :name, product_desc = :desc,';
        $update_product_query.=' product_price = :price, product_image = :image WHERE product_id = :id';
        $update_product_set = $pdo->prepare($update_product_query);
        $update_product_result = $update_product_set->execute(
            array(
                ':name'=>$name,
                ':desc'=>$desc,
                ':price'=>$price,
                ':image'=>$new_name,
                ':id'=>$id,
            )
        );

        $last_uploaded_id = $pdo->lastInsertId();
        if ($insert_p_result && !empty($last_uploaded_id)) {
            $update_category_query = 'INSERT INTO tbl_category_product(product_id, category_id) VALUES(:product_id, :category_id)';
            $update_category       = $pdo->prepare($update_category_query);

            $update_category_result = $update_category->execute(
                array(
                    ':product_id' => $last_uploaded_id,
                    ':category_id'  => $category
                )
            );
        }
        
        if($update_product_result){
            redirect_to('index.php');
        }else{
            return 'something went wrong...';
        }

  } catch (Exception $e) {
        $error = $e->getMessage();
        return $error;
    }
}

function deleteProduct($id){
    $pdo = Database::getInstance()->getConnection();

    $delete_product_query = 'DELETE FROM `tbl_product` WHERE product_id = :id';
    $delete_product_set = $pdo->prepare($delete_product_query);
    $delete_product_result = $delete_product_set->execute(
        array(
            ':id'=>$id,
        )
    );
    
    if($delete_product_result && $delete_product_set->rowCount() > 0){
        redirect_to('admin_deleteproduct.php');
    }else{
        return false;
    }

}
function createProduct($name, $desc, $price, $category, $img){
    try {
        $pdo = Database::getInstance()->getConnection();
        //validate the file, must be image
        $file_type      = pathinfo($img['name'], PATHINFO_EXTENSION);
        $accepted_types = array('gif', 'jpg', 'jpe', 'jpeg', 'png');
        if (!in_array($file_type, $accepted_types)) { //if not the right extentions
            throw new Exception('Wrong file type!');
        }

        //take the temporary file and store it
        $new_name = uniqid() . '.' .  $file_type;
        $target_path = '../images/' . $new_name;
        if (!move_uploaded_file($img['tmp_name'], $target_path)) {
            throw new Exception('Failed to move uploaded file!');
        }

        //insert the product information into the db
        $insert_p_query = 'INSERT INTO tbl_product (product_name, product_desc, product_price, product_image) VALUES (:Pname, :Pdesc, :Pprice, :Pimg)';

        $insert_p       = $pdo->prepare($insert_p_query);
        $insert_p_result = $insert_p->execute(
            array(
                ':Pname'     => $name,
                ':Pdesc'      => $desc,
                ':Pprice'   => $price,
                ':Pimg'     => $new_name
            )
        );

        //get the most recent rows id
        $last_uploaded_id = $pdo->lastInsertId();
        if ($insert_p_result && !empty($last_uploaded_id)) {
            $update_category_query = 'INSERT INTO tbl_category_product(product_id, category_id) VALUES(:product_id, :category_id)';
            $update_category       = $pdo->prepare($update_category_query);

            $update_category_result = $update_category->execute(
                array(
                    ':product_id' => $last_uploaded_id,
                    ':category_id'  => $category
                )
            );
        }
        //if everything works, redirect to product list
        redirect_to('index.php');

        //catch any thrown errors and return them
    } catch (Exception $e) {
        $error = $e->getMessage();
        return $error;
    }
}