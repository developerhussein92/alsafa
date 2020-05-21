
<?php

include_once "header.php";
if($_SESSION["mystatus"]!=0){
  $month = date('n'); 
  $curday = date('y-m-d');
?>

<div class="alert alert-danger"  role="alert">
عرض المبيعات للوجبات فقط ليوم
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
</tr>
<thead>
<tbody>
<?php 
$day = date('Y-m-d');
$sql = "
SELECT sales.san_code,sales.number,sales.date_to_sales,san.name
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