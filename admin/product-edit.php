<?php
include('authentication.php');
include('config/dbcon.php');

include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

<?php
if(isset($_GET['prod_id']))
{
    $product_id = $_GET['prod_id'];
    $query = "SELECT * FROM products WHERE id = '$product_id'";
    $query_run = mysqli_query($con, $query);

    if(mysqli_num_rows($query_run)> 0)
    {
        $productItem = mysqli_fetch_array($query_run);
        ?>



<section class="content mt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php include('messege.php'); ?>
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Product EDIT
                            <a href="product.php" class="btn btn-danger float-right">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="product_id" value="<?=$productItem['id']?>">

                        <div class="row">
                            <div class="col-md-12">
                                <label>Select Category</label>
                                <?php
                                    $query = "SELECT * FROM categories";
                                    $query_run = mysqli_query($con, $query);
                                    if(mysqli_num_rows($query_run)>0)
                                    {
                                        {
                                            ?>
                                            <select name="category_id" required class="form-control">
                                                <option value="">Select Category</option>
                                                <?php foreach($query_run as $item) {?>
                                                <option value="<?=$item['id']?>" <?= $productItem['category_id'] == $item['id']? 'selected':''?>>
                                                    <?=$item['name']?>
                                                </option>
                                            <?php }?>
                                            </select>
                                            <?php
                                        }
                                    }
                                ?>
                            </div>
                            <div  class="col-md-12">
                                <div class="form-group">
                                    <label for="">Product Name</label>
                                    <input type="text" name="name" class="form-control" value="<?=$productItem['name']?>" placeholder="Enter Product Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Small Description</label>
                                    <textarea name="small_description" class="form-control" required rows="3" placeholder="Enter Small Description"><?=$productItem['small_description']?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Long Description</label>
                                    <textarea name="long_description" class="form-control" required rows="3" placeholder="Enter Long Description"><?=$productItem['long_description']?></textarea>
                                 </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="text" name="price"  class="form-control" value="<?=$productItem['price']?>" required placeholder="Enter Price">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Offer Price</label>
                                    <input type="text" name="offerprice" class="form-control" value="<?=$productItem['offerprice']?>" required placeholder="Enter Offer Price">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">TAX</label>
                                    <input type="text" name="tax" class="form-control" value="<?=$productItem['tax']?>" required placeholder="Enter Tax">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Quantity</label>
                                    <input type="text" name="quantity" class="form-control"  value="<?=$productItem['quantity']?>" required placeholder="Enter Quantity">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status(checked = Show | Hide)</label> <br>
                                    <input type="checkbox" name="status"><?=$productItem['status']== '1'? 'checked':''?> Show | Hide
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Upload Image</label>
                                    <input type="file" name="image" class="form-control" >
                                    <input type="hidden" name="old_image" value="<?=$productItem['image']?>">
                                </div>
                                <img src="uploads/product/<?=$productItem['image']?>" width="50px" height="50px" alt="Image">
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> Click to Save</label> <br>
                                    <button type="submit" name="product_update" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    }
    else
    {
        echo "No such Product Found";
    }
}
?>

</div>


<?php include('includes/script.php');?>
<?php include('includes/footer.php');?>