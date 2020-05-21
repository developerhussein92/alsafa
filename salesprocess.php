
<?php

include_once "header.php";
if($_SESSION["mystatus"]!=0){
  $month = date('n'); 
  $curday = date('y-m-d');
  if (isset($_GET['del'])) {
    $id = $_GET['findhscode'];
    
    $sql = "DELETE FROM sales WHERE id=$id";

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
تعديل او حذف مبيعات 
<?php 
        $d = date('d');
        $m = $armonth[$month-1];
        $y = date('Y');
        echo $d." - ".$m." - ".$y;
    
    ?>   
</div>
<form>
<table class="table table-hover table-bordered table-striped table-dark">  
<thead style="">
<tr>
  <th>اسم الوجبة</th>
  <th>كود الوجبة</th>
  <th>العدد</th>
  <th>تاريخ البيع</th>
  <th>العمليات</th>
</tr>
<thead>
<tbody>
<?php 
$day = date('Y-m-d');
$sql = "
SELECT sales.id,sales.san_code,sales.number,sales.date_to_sales,san.name
FROM sales
INNER JOIN  san ON sales.san_code = san.code 
WHERE date(sales.date_to_sales) = '$day';
";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
?>
<tr>
<td><?php echo $row["name"]."  "; ?></td>
<td><?php echo $row["san_code"]."  "; ?></td>
<td><?php echo $row["number"]."  "; ?></td>
<td><?php echo $row["date_to_sales"]."  "; ?></td>
<td  style="text-align:center">
    
   <form action="salesprocess.php" method="GET"> 
    <input style="margin-left:20px" class="btn btn-danger" name="del" type="submit" value="حذف العنصر" />
    <input type="hidden" name= "findhscode" value="<?php echo $row["id"]?>"/>
    <input type="hidden" name= "name" value="<?php echo $row["name"]?>"/>
    <input class="btn btn-secondary" type="submit" name="edit" value="تعديل البيانات"  formmethod = "POST" formaction="salesedit.php"/>
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