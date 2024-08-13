<?php

if(!isset($_SESSION['admin_email'])){
    echo "<script>window.open('../login.php','_self')</script>";
}

else {


?>

<!-- HTML code remains the same -->

<div class="panel-body" ><!-- panel-body Starts -->

<div class="table-responsive" ><!-- table-responsive Starts -->

<table class="table table-bordered table-hover table-striped" ><!-- table table-bordered table-hover table-striped Starts -->

<thead><!-- thead Starts -->

<tr>

<th>Customer No:</th>
<th>Customer Name:</th>
<th>Customer Email:</th>
<th>Customer Phone Number:</th>

<th>Customer Country:</th>
<th>Customer Delete:</th>


</tr>

</thead><!-- thead Ends -->


<tbody><!-- tbody Starts -->

<?php

$i=0;

$get_c = "select * from admins WHERE admin_job ='user'";

$run_c = mysqli_query($con,$get_c);

while($row_c=mysqli_fetch_array($run_c)){

$c_id = $row_c['admin_id'];

$c_name = $row_c['admin_name'];

$c_email = $row_c['admin_email'];

$c_contact = $row_c['admin_contact'];

$c_country = $row_c['admin_country'];

$i++;




?>

<tr>

<td><?php echo $i; ?></td>

<td><?php echo $c_name; ?></td>

<td><?php echo $c_email; ?></td>

<td><?php echo $c_contact; ?></td>

<td><?php echo $c_country; ?></td>

<td>

<a href="index.php?customer_delete=<?php echo $c_id; ?>" >

<i class="fa fa-trash-o" ></i> Delete

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