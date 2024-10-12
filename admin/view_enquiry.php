<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else {
?>
    <div class="row"><!-- 1 row Starts -->
        <div class="col-lg-12"><!-- col-lg-12 Starts -->
            <ol class="breadcrumb"><!-- breadcrumb Starts -->
                <li class="active">
                    <i class="fa fa-dashboard"></i> Dashboard / View Contact Inquiries
                </li>
            </ol><!-- breadcrumb Ends -->
        </div><!-- col-lg-12 Ends -->
    </div><!-- 1 row Ends -->
    <div class="row"><!-- 2 row Starts -->
        <div class="col-lg-12"><!-- col-lg-12 Starts -->
            <div class="panel panel-default"><!-- panel panel-default Starts -->
                <div class="panel-heading"><!-- panel-heading Starts -->
                    <h3 class="panel-title">
                        <i class="fa fa-envelope fa-fw"></i> View Contact Inquiries
                    </h3>
                </div><!-- panel-heading Ends -->
                <div class="panel-body"><!-- panel-body Starts -->
                    <div class="table-responsive"><!-- table-responsive Starts -->
                        <table class="table table-bordered table-hover table-striped"><!-- table table-bordered table-hover table-striped Starts -->
                            <thead>
                                <tr>
                                    <th>Contact Id</th>
                                    <th>Name</th> <!-- New Name Field -->
                                    <th>Contact Email</th>
                                    <th>Contact Heading</th>
                                    <th>Contact Description</th>
                                    <th>Delete Inquiry</th>
                                </tr>
                            </thead>
                            <tbody><!-- tbody Starts -->
                                <?php
                                $i = 0;
                                $get_contacts = "SELECT * FROM contact_us"; // Adjust the table name if needed
                                $run_contacts = mysqli_query($con, $get_contacts);
                                while ($row_contacts = mysqli_fetch_array($run_contacts)) {
                                    $contact_id = $row_contacts['contact_id'];
                                    $contact_name = $row_contacts['name']; // Fetching the new name field
                                    $contact_email = $row_contacts['contact_email'];
                                    $contact_heading = $row_contacts['contact_heading'];
                                    $contact_desc = $row_contacts['contact_desc'];
                                    $i++;
                                ?>
                                    <tr>
                                        <td> <?php echo $contact_id; ?> </td>
                                        <td> <?php echo $contact_name; ?> </td> <!-- Displaying the Name -->
                                        <td> <?php echo $contact_email; ?> </td>
                                        <td> <?php echo $contact_heading; ?> </td>
                                        <td> <?php echo $contact_desc; ?> </td>
                                        <td>
                                            <a href="index.php?delete_contact=<?php echo $contact_id; ?>">
                                                <i class="fa fa-trash-o"> </i> Delete
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
<?php
}

// Delete contact inquiry logic
if (isset($_GET['delete_contact'])) {
    $delete_contact_id = $_GET['delete_contact'];
    $delete_query = "DELETE FROM contact_us WHERE contact_id='$delete_contact_id'";
    $run_delete = mysqli_query($con, $delete_query);

    if ($run_delete) {
        echo "<script>alert('Contact inquiry has been deleted!')</script>";
        echo "<script>window.open('index.php?view_contacts','_self')</script>"; // Redirect to the same page
    } else {
        echo "<script>alert('Error deleting contact inquiry. Please try again.')</script>";
    }
}
?>
