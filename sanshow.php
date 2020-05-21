
<?php

include_once "header.php";
if($_SESSION["mystatus"]!=0){
?>

<div class="alert alert-danger"  role="alert">
عرض الاصناف 
</div>
<form>
<table class="table table-hover table-bordered table-striped table-dark">  
<thead style="">
<tr>
  <th>اسم الوجبة</th>
  <th>CODE</th>
</tr>
<thead>
<tbody>
<?php 

$sql = "
SELECT *
FROM san
";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
?>
<tr>
<td><a style="color:white" href="sanadditems.php?code=<?php echo $row['code'];?>&&name=<?php echo $row['name'];?>"><?php echo $row["name"];?></a></td>
<td><?php echo $row["code"]."  "; ?></td>
</tr>   
<?php
  }
  } else {
  echo '<div class="alert alert-warning"  role="alert">
  لا توجد عناصر 
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