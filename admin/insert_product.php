<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('../login.php','_self')</script>";
} else {
?>
    <!DOCTYPE html>
    <html>
    <head>
        <title> Insert Products </title>
        <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
        <script>
            tinymce.init({
                selector: '#product_desc'
            });
        </script>
    </head>
    <body>
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"> </i> Dashboard / Insert Products
                    </li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="fa fa-money fa-fw"></i> Insert Products
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-md-3 control-label"> Product Title </label>
                                <div class="col-md-6">
                                    <input type="text" name="product_title" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"> Product Url </label>
                                <div class="col-md-6">
                                    <input type="text" name="product_url" class="form-control" required>
                                    <br>
                                    <p style="font-size:15px; font-weight:bold;">
                                        Product Url Example : navy-blue-t-shirt
                                    </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"> Select A Manufacturer </label>
                                <div class="col-md-6">
                                    <select class="form-control" name="manufacturer">
                                        <option> Select A Manufacturer </option>
                                        <?php
                                        $get_manufacturer = "select * from manufacturers";
                                        $run_manufacturer = mysqli_query($con, $get_manufacturer);
                                        while ($row_manufacturer = mysqli_fetch_array($run_manufacturer)) {
                                            $manufacturer_id = $row_manufacturer['manufacturer_id'];
                                            $manufacturer_title = $row_manufacturer['manufacturer_title'];
                                            echo "<option value='$manufacturer_id'>$manufacturer_title</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"> Product Category </label>
                                <div class="col-md-6">
                                    <select name="product_cat" class="form-control">
                                        <option> Select a Product Category </option>
                                        <?php
                                        $get_p_cats = "select * from product_categories";
                                        $run_p_cats = mysqli_query($con, $get_p_cats);
                                        while ($row_p_cats = mysqli_fetch_array($run_p_cats)) {
                                            $p_cat_id = $row_p_cats['p_cat_id'];
                                            $p_cat_title = $row_p_cats['p_cat_title'];
                                            echo "<option value='$p_cat_id' >$p_cat_title</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"> Category </label>
                                <div class="col-md-6">
                                    <select name="cat" class="form-control">
                                        <option> Select a Category </option>
                                        <?php
                                        $get_cat = "select * from categories ";
                                        $run_cat = mysqli_query($con, $get_cat);
                                        while ($row_cat = mysqli_fetch_array($run_cat)) {
                                            $cat_id = $row_cat['cat_id'];
                                            $cat_title = $row_cat['cat_title'];
                                            echo "<option value='$cat_id'>$cat_title</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"> Product Image 1 </label>
                                <div class="col-md-6">
                                    <input type="file" name="product_img1" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"> Product Image 2 </label>
                                <div class="col-md-6">
                                    <input type="file" name="product_img2" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"> Product Image 3 </label>
                                <div class="col-md-6">
                                    <input type="file" name="product_img3" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"> Product Image 4 </label>
                                <div class="col-md-6">
                                    <input type="file" name="product_img4" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"> Product Image 5 </label>
                                <div class="col-md-6">
                                    <input type="file" name="product_img5" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"> Product Price </label>
                                <div class="col-md-6">
                                    <input type="text" name="product_price" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"> Product Sale Price </label>
                                <div class="col-md-6">
                                    <input type="text" name="psp_price" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-6">
                                    <input type="submit" name="submit" value="Insert Product" class="btn btn-primary form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
<?php
    if (isset($_POST['submit'])) {
        $product_title = $_POST['product_title'];
        $product_cat = $_POST['product_cat'];
        $cat = $_POST['cat'];
        $manufacturer_id = $_POST['manufacturer'];
        $product_price = $_POST['product_price'];
        $psp_price = $_POST['psp_price'];
        $product_url = $_POST['product_url'];
        $status = "product"; // Check if you really need this column, or add it to the database if necessary.
        $product_img1 = $_FILES['product_img1']['name'];
        $product_img2 = $_FILES['product_img2']['name'];
        $product_img3 = $_FILES['product_img3']['name'];
        $product_img4 = $_FILES['product_img4']['name'];
        $product_img5 = $_FILES['product_img5']['name'];
        $temp_name1 = $_FILES['product_img1']['tmp_name'];
        $temp_name2 = $_FILES['product_img2']['tmp_name'];
        $temp_name3 = $_FILES['product_img3']['tmp_name'];
        $temp_name4 = $_FILES['product_img4']['tmp_name'];
        $temp_name5 = $_FILES['product_img5']['tmp_name'];
        move_uploaded_file($temp_name1, "product_images/$product_img1");
        move_uploaded_file($temp_name2, "product_images/$product_img2");
        move_uploaded_file($temp_name3, "product_images/$product_img3");
        move_uploaded_file($temp_name4, "product_images/$product_img4");
        move_uploaded_file($temp_name5, "product_images/$product_img5");
        $insert_product = "INSERT INTO products (
      p_cat_id, cat_id, manufacturer_id, date, product_title, product_url,
      product_img1, product_img2, product_img3, product_img4, product_img5,
      product_price, product_psp_price, status
  ) VALUES (
      '$product_cat', '$cat', '$manufacturer_id', NOW(), '$product_title', '$product_url',
      '$product_img1', '$product_img2', '$product_img3', '$product_img4', '$product_img5',
      '$product_price', '$psp_price', '$status'
  )";
        $run_product = mysqli_query($con, $insert_product);
        if ($run_product) {
            echo "<script>alert('Product has been inserted successfully')</script>";
            //   echo "<script>window.open('insert_product.php','_self')</script>";
        }
    }
}
?>