<?php
if (!isset($_SESSION['admin_email'])) {
  echo "<script>window.open('login.php','_self')</script>";
} else {
  if (isset($_GET['edit_product'])) {
    $edit_id = $_GET['edit_product'];
    $get_p = "SELECT * FROM products WHERE product_id='$edit_id'";
    $run_edit = mysqli_query($con, $get_p);
    $row_edit = mysqli_fetch_array($run_edit);
    $p_id = $row_edit['product_id'];
    $p_title = $row_edit['product_title'];
    $p_cat = $row_edit['p_cat_id'];
    $cat = $row_edit['cat_id'];
    $m_id = $row_edit['manufacturer_id'];
    $p_image1 = $row_edit['product_img1'];
    $p_image2 = $row_edit['product_img2'];
    $p_image3 = $row_edit['product_img3'];
    $p_image4 = $row_edit['product_img4'];
    $p_image5 = $row_edit['product_img5'];
    $new_p_image1 = $p_image1;
    $new_p_image2 = $p_image2;
    $new_p_image3 = $p_image3;
    $new_p_image4 = $p_image4;
    $new_p_image5 = $p_image5;
    $p_price = $row_edit['product_price'];
    $psp_price = $row_edit['product_psp_price'];
    $p_desc = $row_edit['product_desc'];
    $p_url = $row_edit['product_url'];
  }
  $get_manufacturer = "SELECT * FROM manufacturers WHERE manufacturer_id='$m_id'";
  $run_manufacturer = mysqli_query($con, $get_manufacturer);
  $row_manfacturer = mysqli_fetch_array($run_manufacturer);
  $manufacturer_id = $row_manfacturer['manufacturer_id'];
  $manufacturer_title = $row_manfacturer['manufacturer_title'];
  $get_p_cat = "SELECT * FROM product_categories WHERE p_cat_id='$p_cat'";
  $run_p_cat = mysqli_query($con, $get_p_cat);
  $row_p_cat = mysqli_fetch_array($run_p_cat);
  $get_cat = "SELECT * FROM categories WHERE cat_id='$cat'";
  $run_cat = mysqli_query($con, $get_cat);
  $row_cat = mysqli_fetch_array($run_cat);
  $cat_title = $row_cat['cat_title'];
?>
  <!DOCTYPE html>
  <html>
  <head>
    <title>Edit Products</title>
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
            <i class="fa fa-dashboard"></i> Dashboard / Edit Products
          </li>
        </ol>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">
              <i class="fa fa-money fa-fw"></i> Edit Products
            </h3>
          </div>
          <div class="panel-body">
            <form class="form-horizontal" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label class="col-md-3 control-label">Product Title</label>
                <div class="col-md-6">
                  <input type="text" name="product_title" class="form-control" required value="<?php echo $p_title; ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Product Url</label>
                <div class="col-md-6">
                  <input type="text" name="product_url" class="form-control" required value="<?php echo $p_url; ?>">
                  <br>
                  <p style="font-size:15px; font-weight:bold;">
                    Product Url Example: navy-blue-t-shirt
                  </p>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Select A Manufacturer</label>
                <div class="col-md-6">
                  <select name="manufacturer" class="form-control">
                    <option value="<?php echo $manufacturer_id; ?>"><?php echo $manufacturer_title; ?></option>
                    <?php
                    $get_manufacturer = "SELECT * FROM manufacturers";
                    $run_manufacturer = mysqli_query($con, $get_manufacturer);
                    while ($row_manfacturer = mysqli_fetch_array($run_manufacturer)) {
                      $manufacturer_id = $row_manfacturer['manufacturer_id'];
                      $manufacturer_title = $row_manfacturer['manufacturer_title'];
                      echo "<option value='$manufacturer_id'>$manufacturer_title</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Product Category</label>
                <div class="col-md-6">
                  <select name="product_cat" class="form-control">
                    <option value="<?php echo $p_cat; ?>"><?php echo $p_cat_title; ?></option>
                    <?php
                    $get_p_cats = "SELECT * FROM product_categories";
                    $run_p_cats = mysqli_query($con, $get_p_cats);
                    while ($row_p_cats = mysqli_fetch_array($run_p_cats)) {
                      $p_cat_id = $row_p_cats['p_cat_id'];
                      $p_cat_title = $row_p_cats['p_cat_title'];
                      echo "<option value='$p_cat_id'>$p_cat_title</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Category</label>
                <div class="col-md-6">
                  <select name="cat" class="form-control">
                    <option value="<?php echo $cat; ?>"><?php echo $cat_title; ?></option>
                    <?php
                    $get_cat = "SELECT * FROM categories";
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
                <label class="col-md-3 control-label">Product Image 1</label>
                <div class="col-md-6">
                  <input type="file" name="product_img1" class="form-control">
                  <br><img src="product_images/<?php echo $p_image1; ?>" width="70" height="70">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Product Image 2</label>
                <div class="col-md-6">
                  <input type="file" name="product_img2" class="form-control">
                  <br><img src="product_images/<?php echo $p_image2; ?>" width="70" height="70">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Product Image 3</label>
                <div class="col-md-6">
                  <input type="file" name="product_img3" class="form-control">
                  <br><img src="product_images/<?php echo $p_image3; ?>" width="70" height="70">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Product Image 4</label>
                <div class="col-md-6">
                  <input type="file" name="product_img4" class="form-control">
                  <br><img src="product_images/<?php echo $p_image4; ?>" width="70" height="70">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Product Image 5</label>
                <div class="col-md-6">
                  <input type="file" name="product_img5" class="form-control">
                  <br><img src="product_images/<?php echo $p_image5; ?>" width="70" height="70">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Product Price</label>
                <div class="col-md-6">
                  <input type="text" name="product_price" class="form-control" required value="<?php echo $p_price; ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Product Sale Price</label>
                <div class="col-md-6">
                  <input type="text" name="psp_price" class="form-control" required value="<?php echo $psp_price; ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Product Description</label>
                <div class="col-md-6">
                  <textarea name="product_desc" id="product_desc" cols="19" rows="6" class="form-control"><?php echo $p_desc; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label"></label>
                <div class="col-md-6">
                  <input type="submit" name="update" value="Update Product" class="btn btn-primary form-control">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php
    if (isset($_POST['update'])) {
      $product_title = $_POST['product_title'];
      $product_cat = $_POST['product_cat'];
      $cat = $_POST['cat'];
      $manufacturer_id = $_POST['manufacturer'];
      $product_price = $_POST['product_price'];
      $psp_price = $_POST['psp_price'];
      $product_desc = $_POST['product_desc'];
      $product_url = $_POST['product_url'];
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
      if (empty($product_img1)) {
        $product_img1 = $new_p_image1;
      }
      if (empty($product_img2)) {
        $product_img2 = $new_p_image2;
      }
      if (empty($product_img3)) {
        $product_img3 = $new_p_image3;
      }
      if (empty($product_img4)) {
        $product_img4 = $new_p_image4;
      }
      if (empty($product_img5)) {
        $product_img5 = $new_p_image5;
      }
      move_uploaded_file($temp_name1, "product_images/$product_img1");
      move_uploaded_file($temp_name2, "product_images/$product_img2");
      move_uploaded_file($temp_name3, "product_images/$product_img3");
      move_uploaded_file($temp_name4, "product_images/$product_img4");
      move_uploaded_file($temp_name5, "product_images/$product_img5");
      $update_product = "UPDATE products SET
                        product_title='$product_title',
                        p_cat_id='$product_cat',
                        cat_id='$cat',
                        manufacturer_id='$manufacturer_id',
                        product_img1='$product_img1',
                        product_img2='$product_img2',
                        product_img3='$product_img3',
                        product_img4='$product_img4',
                        product_img5='$product_img5',
                        product_price='$product_price',
                        product_psp_price='$psp_price',
                        product_desc='$product_desc',
                        product_url='$product_url'
                        WHERE product_id='$p_id'";
      $run_product = mysqli_query($con, $update_product);
      if ($run_product) {
        echo "<script>alert('Product has been updated successfully')</script>";
        echo "<script>window.open('index.php?view_products','_self')</script>";
      }
    }
    ?>
  </body>
  </html>
<?php } ?>