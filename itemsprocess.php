
<?php

include_once "header.php";
if($_SESSION["mystatus"]!=0){
  if (isset($_GET['del'])) {
    $id = $_GET['findhscode'];
    
    $sql = "DELETE FROM items WHERE hscode=$id";

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
تعديل او حذف الاصناف 
</div>
<form>
<table class="table table-hover table-bordered table-striped table-dark">  
<thead style="">
<tr>
  <th>اسم الصنف</th>
  <th>HSCODE</th>
  <th>قيمة اهلاكات ( التنظيف والتسويه )</th>
  <th>العمليات</th>
</tr>
<thead>
<tbody>
<?php 

$sql = "
SELECT *
FROM items
";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
?>
<tr>
<td><?php echo $row["name"]."    " ; ?></td>
<td><?php echo $row["hscode"]."  "; ?></td>
<td><?php echo $row["dest"]."  "; ?></td>
<td  style="text-align:center">
    
   <form action="itemsprocess.php" method="GET"> 
    <input style="margin-left:20px" class="btn btn-danger" name="del" type="submit" value="حذف العنصر" />
    <input type="hidden" name= "findhscode" value="<?php echo $row["hscode"]?>"/>
    <input class="btn btn-secondary" type="submit" name="edit" value="تعديل البيانات"  formmethod = "POST" formaction="itemsedit.php"/>
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