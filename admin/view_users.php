<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('../login.php','_self')</script>";
} else {
?>
    <div class="row"><!-- 1 row Starts -->
        <div class="col-lg-12"><!-- col-lg-12 Starts -->
            <ol class="breadcrumb"><!-- breadcrumb Starts -->
                <li class="active">
                    <i class="fa fa-dashboard"></i> Dashboard / View Admins
                </li>
            </ol><!-- breadcrumb Ends -->
        </div><!-- col-lg-12 Ends -->
    </div><!-- 1 row Ends -->
    <div class="row"><!-- 2 row Starts -->
        <div class="col-lg-12"><!-- col-lg-12 Starts -->
            <div class="panel panel-default"><!-- panel panel-default Starts -->
                <div class="panel-heading"><!-- panel-heading Starts -->
                    <h3 class="panel-title"><!-- panel-title Starts -->
                        <i class="fa fa-money fa-fw"></i> View Admins
                    </h3><!-- panel-title Ends -->
                </div><!-- panel-heading Ends -->
                <div class="panel-body"><!-- panel-body Starts -->
                    <div class="table-responsive"><!-- table-responsive Starts -->
                        <table class="table table-bordered table-hover table-striped">
                            <!-- table table-bordered table-hover table-striped Starts -->
                            <thead><!-- thead Starts -->
                                <tr>
                                    <th>Admin ID:</th>
                                    <th>Admin Name:</th>
                                    <th>Admin Email:</th>
                                    <th>Admin Contact:</th>
                                    <th>Admin Country:</th>
                                    <th>Admin Job:</th>
                                    <th>About Admin:</th>
                                    <th>Admin Photo:</th>
                                    <th>Delete Admin:</th>
                                </tr>
                            </thead><!-- thead Ends -->
                            <tbody><!-- tbody Starts -->
                                <?php
                                $get_admin = "select * from admins WHERE admin_job ='admin'";
                                $run_admin = mysqli_query($con, $get_admin);
                                while ($row_admin = mysqli_fetch_array($run_admin)) {
                                    $admin_id = $row_admin['admin_id'];
                                    $admin_name = $row_admin['admin_name'];
                                    $admin_email = $row_admin['admin_email'];
                                    $admin_contact = $row_admin['admin_contact'];
                                    $admin_country = $row_admin['admin_country'];
                                    $admin_job = $row_admin['admin_job'];
                                    $admin_about = $row_admin['admin_about'];
                                    $admin_image = $row_admin['admin_image'];
                                ?>
                                    <tr>
                                        <td><?php echo $admin_id; ?></td>
                                        <td><?php echo $admin_name; ?></td>
                                        <td><?php echo $admin_email; ?></td>
                                        <td><?php echo $admin_contact; ?></td>
                                        <td><?php echo $admin_country; ?></td>
                                        <td><?php echo $admin_job; ?></td>
                                        <td><?php echo $admin_about; ?></td>
                                        <td><img src="admin_images/<?php echo $admin_image; ?>" width="60" height="60"></td>
                                        <td>
                                            <a
                                                href="index.php?admin_delete=<?php echo $admin_id; ?>&admin_image=<?php echo $row_admin['admin_image']; ?>">
                                                <i class="fa fa-trash-o"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody><!-- tbody Ends -->
                        </table><!-- table table-bordered table-hover table-striped Ends -->
                    </div><!-- table-responsive Ends -->
                </div><!-- panel-body Ends -->
            </div><!-- panel panel-default Ends -->
        </div><!-- col-lg-12 Ends -->
    </div><!-- 2 row Ends -->
<?php } ?>
<?php
if (isset($_GET['admin_delete'])) {
    $delete_id = $_GET['admin_delete'];
    $delete_admin = "delete from admins where admin_id='$delete_id'";
    $run_delete = mysqli_query($con, $delete_admin);
    if ($run_delete) {
        echo "<script>alert('Admin Has Been Deleted')</script>";
        echo "<script>window.open('index.php?view_admins','_self')</script>";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>