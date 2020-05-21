
<?php

include_once "header.php";
if($_SESSION["mystatus"]!=0){
  if (isset($_GET['del'])) {
    $id = $_GET['findhscode'];
    
    $sql = "DELETE FROM san WHERE code=$id";

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
  <th>اسم الوجبة</th>
  <th>كود الوجبة</th>
  <th>العمليات</th>
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
<td><?php echo $row["name"]."    " ; ?></td>
<td><?php echo $row["code"]."  "; ?></td>
<td  style="text-align:center">
    
   <form action="sanprocess.php" method="GET"> 
    <input style="margin-left:20px" class="btn btn-danger" name="del" type="submit" value="حذف العنصر" />
    <input type="hidden" name= "findhscode" value="<?php echo $row["code"]?>"/>
    <input type="hidden" name= "name" value="<?php echo $row["name"]?>"/>
    <input class="btn btn-secondary" type="submit" name="edit" value="تعديل البيانات"  formmethod = "POST" formaction="sanedit.php"/>
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