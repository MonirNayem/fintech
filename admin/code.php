<?php

include('authentication.php');
include('config/dbcon.php');


if(isset($_POST['product_update']))
{
    $product_id = $_POST['product_id'];
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $small_description = $_POST['small_description'];
    $long_description = $_POST['long_description'];
    $price = $_POST['price'];
    $offerprice = $_POST['offerprice'];
    $tax = $_POST['tax'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'] == true ? '1':'0';

    $image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];

    if($image != '')
    {
        $update_filename = $_FILES['image']['name'];

        $allowed_extention = array('png','jpg','jpeg');
        $file_extention = pathinfo($update_filename, PATHINFO_EXTENSION);

        $filename= time().'.'.$file_extention;

        if(!in_array($file_extention, $allowed_extention))
        {
            $_SESSION['status'] = "You are allowed only jpg, png, jpeg image";
            header('Location: product-add.php');
            exit(0);
        }
        $update_filename = $filename;
    }
    else
    {
        $update_filename = $old_image;
    }

    $query = "UPDATE products SET category_id ='$category_id',name='$name',small_description='$small_description',long_description='$long_description',price='$price',offerprice='$offerprice',tax='$tax',quantity='$quantity',image='$update_filename',status='$status' WHERE id='$product_id'";

    $query_run = mysqli_query($con, $query);
    if($query_run)
    {
        if($image != '')
        {
            move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/product/'.$filename);
            if(file_exists('uploads/product/'.$old_image))
            {
                unlink("uploads/product/".$old_image);
            }
        }
        $_SESSION['status'] = "Product Updated Successfully";
        header('Location: product-edit.php?prod_id='.$product_id);
        exit(0);
    }
    else
    {
        $_SESSION['status'] = "Product Not Updated";
        header('Location: product-edit.php?prod_id='.$product_id);
        exit(0);
    }
}

if(isset($_POST['product_save']))
{
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $small_description = $_POST['small_description'];
    $long_description = $_POST['long_description'];
    $price = $_POST['price'];
    $offerprice = $_POST['offerprice'];
    $tax = $_POST['tax'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'] == true ? '1':'0';
    $image = $_FILES['image']['name'];

    $allowed_extention = array('png','jpg','jpeg');
    $file_extention = pathinfo($image, PATHINFO_EXTENSION);

    $filename= time().'.'.$file_extention;

    if(!in_array($file_extention, $allowed_extention))
    {
        $_SESSION['status'] = "You are allowed only jpg, png, jpeg image";
        header('Location: product-add.php');
        exit(0);
    }
    else
    {
        $query = "INSERT INTO products (category_id,name,small_description,long_description,price,offerprice,tax,quantity,image,status) VALUES ('$category_id','$name',' $small_description','$long_description','$price','$offerprice','$tax','$quantity','$filename','$status')";
        $query_run = mysqli_query($con, $query);
        if($query_run)
        {
            move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/product/'.$filename);
            $_SESSION['status'] = "Product Added Successfully";
            header('Location: product-add.php');
            exit(0);
        }
        else
        {
            $_SESSION['status'] = "Something went wrong";
            header('Location: product-add.php');
            exit(0);
        }
    }
}


if(isset($_POST['category_save']))
{
    $name = $_POST['name'];
    $description = $_POST['description'];
    $trending = $_POST['trending']== true? '1':'0';
    $status = $_POST['status']== true? '1':'0';

    $category_query = "INSERT INTO categories(name,description,trending,status) VALUES('$name','$description','$trending','$status')";

    $category_query_run=mysqli_query($con, $category_query);
    if($category_query_run)
    {
        $_SESSION['status'] = "Category Inserted Successfully";
        header("Location: category.php");
    }
    else
    {
        $_SESSION['status'] = "Category Insertion Failed.!";
        header("Location: category.php");
    }
}

if(isset($_POST['category_update']))
{
    $cate_id = $_POST['cate_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $trending = $_POST['trending'] == true ? '1':'0';
    $status = $_POST['status'] == true ? '1':'0';

    $query ="UPDATE categories SET name='$name',description='$description',trending='$trending', status='status' WHERE id='$cate_id'";
    $query_run= mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Category Updated Successfully";
        header("Location: category.php");
    }
    else
    {
        $_SESSION['status'] = "Category Updating Failed.!";
        header("Location: category.php");
    }
}

if(isset($_POST['cate_delete_btn']))
{
    $cate_id = $_POST['cate_delete_id'];
    $query = "DELETE FROM categories WHERE id='$cate_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Category Deleted Successfully";
        header("Location: category.php");
    }
    else
    {
        $_SESSION['status'] = "Category Delateing Failed.!";
        header("Location: category.php");
    }
}


if(isset($_POST['logout_btn']))
{
    //session_destroy();
    unset($_SESSION['auth']);
    unset($_SESSION['auth_user']);

    $_SESSION['status'] = "Logout Successfully";
    header('Location: login.php');
    exit(0);
}

if(isset($_POST['check_Emailbtn']))

{
    $email = $_POST['email'];

    $checkemail= "SELECT email FROM users WHERE email='$email'";
    $checkemail_run= mysqli_query($con, $checkemail);

        if(mysqli_num_rows($checkemail_run) > 0)
        {
            echo "Email Id  already taken.!";
        }
        else
        {
            echo "It's Available";
        }
}

if (isset($_POST['addUser']))
{
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];

    if ($password == $confirmpassword)
    {
        $checkemail= "SELECT email FROM users WHERE email='$email'";
        $checkemail_run = mysqli_query($con, $checkemail);

        if(mysqli_num_rows($checkemail_run) > 0)
        {
            //Taken- Already
            $_SESSION['status'] = "Email id is already taken.!";
            header("Location: registered.php");
            exit;
        }
        else
        {
            //Available = Record not found
            $user_query = "INSERT INTO users(name,phone,email,password) VALUE('$name','$phone','$email','$password')";
            $user_query_run = mysqli_query($con, $user_query);
        if ($user_query_run)
        {
            $_SESSION['status'] = "User Added Successfully";
            header("Location: registered.php");
        }
        else
        {
            $_SESSION['status'] = "User Registration Failed";
            header("Location: registered.php");
        }
        }

    }
    else
    {
        $_SESSION['status'] = "Password and Confirm Password does not Match";
        header("Location: registered.php");
    }
}


if (isset($_POST['updateUser'])) {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role_as = $_POST['role_as'];

    $query = "UPDATE users SET name='$name', phone='$phone', email='$email', password='$password', role_as='$role_as' WHERE id='$user_id' ";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['status'] = "User Updated Successfully";
        header("Location: registered.php");
    } else {
        $_SESSION['status'] = "User Updating Failed";
        header("Location: registered.php");
    }
}


if (isset($_POST['DeleteUserbtn'])) {
    $user_id = $_POST['delete_id'];
    $query = "DELETE FROM users WHERE id='$user_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['status'] = "User Deleted Successfully";
        header("Location: registered.php");
    } else {
        $_SESSION['status'] = "User Deleting Failed";
        header("Location: registered.php");
    }
}
?>