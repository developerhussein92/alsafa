
<?php

include_once "header.php";
if($_SESSION["mystatus"]!=0){
?>

<div class="alert alert-danger"  role="alert">
عرض الموردين 
</div>
<form>
<table class="table table-hover table-bordered table-striped table-dark">  
<thead style="">
<tr>
  <th>اسم المورد</th>
  <th>كود المورد</th>
  <th>تليفون المورد</th>
  <th>فاكس المورد</th>
  <th>ايميل المورد</th>
  <th>عنوان المورد</th>
</tr>
<thead>
<tbody>
<?php 

$sql = "
SELECT *
FROM supplier
";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
?>
<tr>
<td><?php echo $row["name"]."    " ; ?></td>
<td><?php echo $row["code"]."  "; ?></td>
<td><?php echo $row["phone"]."  "; ?></td>
<td><?php echo $row["fax"]."  "; ?></td>
<td><?php echo $row["email"]."  "; ?></td>
<td><?php echo $row["address"]."  "; ?></td>
</tr>   
<?php
  }
  } else {
  echo '<div class="alert alert-warning"  role="alert">
  لا يوجد موردين 
</div>';
  }

?>
</tbody>
</table>
</form>
<?php
}else{
  echo ' <script> window.location.href = "index.php"; </script>';
}
include_once "footer.php";
?>