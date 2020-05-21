
<?php

include_once "header.php";
if($_SESSION["mystatus"]!=0){
  if (isset($_GET['del'])) {
    $id = $_GET['findhscode'];
    
    $sql = "DELETE FROM supplier WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
      echo '<div  id="test" class="alert alert-warning"  role="alert">
           تم الحذف بنجاح 
    </div>  
    
     
    ';
    } else {
       
    }

  }
  
?>

<div class="alert alert-danger"  role="alert">
تعديل او حذف الموردين 
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
  <th>العمليات</th>
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
<td  style="text-align:center;min-width:200px">
    
   <form action="supplierprocess.php" method="GET"> 
    <input style="margin-left:5px" class="btn btn-danger" name="del" type="submit" value="حذف " />
    <input type="hidden" name= "findhscode" value="<?php echo $row["id"]?>"/>
    <input class="btn btn-secondary" type="submit" name="edit" value="تعديل "  formmethod = "POST" formaction="supplieredit.php"/>
  </form>
   
</td>
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