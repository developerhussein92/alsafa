
<?php

include_once "header.php";
if($_SESSION["mystatus"]>=2){
$year = date('Y'); 
?>

<div class="alert alert-danger"  role="alert">
اجمالي استلامات العاشر  خلال عام  <?php echo $year ?> 
</div>
<form>
<table class="table table-hover table-bordered table-striped table-dark">  
<thead style="">
<tr>
  <th>التاريخ</th>
  <th>وارد</th>
</tr>
<thead>
<tbody>
<?php 
$month =date('n');
$year = date('Y');
$total =0;
for($ko = 1 ;$ko<=$month;$ko++)
{
$all = 0;
$sql = "
SELECT items.name,income.account,income.buy_price,income.value,income.sell_price,income.percentage,income.date_to_income
FROM income
INNER JOIN items ON income.items_hscode = items.hscode
WHERE MONTH(income.date_to_income) = $ko AND YEAR(income.date_to_income) = $year
ORDER BY items.hscode,income.date_to_income
";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
       $all += $row["value"];
    
?>  
<?php
  }
  } else {
      $all = 0;
  }
  $total +=$all; 
  

?>
<tr>
<td><?php echo $armonth[$ko-1]; ?></td>
<td><?php echo  $all."  جنيها"; ?></td>
</tr>
<?php  

}

?>
</tbody>
<tfoot style="background-color:green">
      <tr>
          <td style="font-family: monospace;font-size:20px">اجمالي القيمه السنوية</td>
          <td colspan="6" style="text-align:center;font-size:22px;"><?php  echo $total."  ";?>جنيها</td>
      </tr>
</tfoot>
</table>
</form>
<?php
}else{
  echo ' <script> window.location.href = "index.php"; </script>';
}
include_once "footer.php";
?>