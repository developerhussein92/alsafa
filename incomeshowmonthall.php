
<?php

  include_once "header.php";
  if($_SESSION["mystatus"]>=2){
?>

<div class="alert alert-danger"  role="alert">
عرض قائمة الاسعار الشهرية اجماليا 
</div>
<form>
<table class="table table-hover table-bordered table-striped table-dark">  
<thead style="">
<tr>
    <th>اسم الصنف</th>
    <th>وارد</th>
    <th>سعر الشراء</th>
    <th>القيمة</th>
    <th>سعر البيع</th>
    <th>النسبة</th>
    <th>تاريخ الوارد</th>
</tr>
<thead>
<tbody>
<?php 

$start = date('Y-m-01');  
$end = date('Y-m-d 23:59:59');
$sql = "
SELECT items.name,income.account,income.buy_price,income.value,income.sell_price,income.percentage,income.date_to_income
FROM income
INNER JOIN items ON income.items_hscode = items.hscode
WHERE date(income.date_to_income)  BETWEEN '$start' AND '$end'
ORDER BY items.hscode
";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
?>
<tr>
<td  style="background-color:#291b1b;font-family: monospace;font-size:20px"><?php echo $row["name"]; ?></td>
<td><?php echo $row["account"]."    " ; ?>كجم</td>
<td><?php echo $row["buy_price"]."  "; ?>جنيها</td>
<td><?php echo $row["value"]." " ; ?> جنيها</td>
<td><?php echo $row["sell_price"]."  "; ?>جنيها</td>
<td><?php echo $row["percentage"]."  "; ?>%</td>
<td><?php echo  $row["date_to_income"]; ?></td>
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