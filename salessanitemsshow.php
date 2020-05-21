
<?php

include_once "header.php";
if($_SESSION["mystatus"]!=0){
  $month = date('n'); 
  $curday = date('y-m-d');
  $day = date('Y-m-d');
?>

<div class="alert alert-danger"  role="alert">
عرض المبيعات للوجبات والاصناف تفصيليا ليوم 
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

  <th>كود الوجبة</th>
  <th>العدد</th>
  <th>كود الصنف</th>
  <th>المبيعات بالكيلو</th>
  <th>تاريخ البيع</th>
</tr>
<thead>
<tbody>
<?php 


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
      $san_code = $row['san_code'];    

    $sql3 = "
    SELECT count(items_hscode) AS myres
    FROM itemssan
    WHERE san_code = $san_code
    ";
    $result3 = mysqli_query($conn, $sql3);
    if (mysqli_num_rows($result3) > 0) {
      // output data of each row
      
      while($row3 = mysqli_fetch_assoc($result3)) {
      $myres = $row3['myres'];
      ?>

<td rowspan="<?php echo $myres;?>"><?php  echo $row['name']; ?></td>
<td rowspan="<?php echo $myres;?>"><?php  echo $row['number']; ?></td>

      <?php 

}}
    $sql2 = "
SELECT itemssan.items_hscode,itemssan.percentage,itemssan.san_code,items.name
FROM itemssan
INNER JOIN  items ON itemssan.items_hscode = items.hscode 
WHERE san_code = $san_code;

";
$result2 = mysqli_query($conn, $sql2);
if (mysqli_num_rows($result2) > 0) {
  // output data of each row

  while($row2 = mysqli_fetch_assoc($result2)) {
    $perc = $row2['percentage'];


?>

<td><?php echo $row2["name"]."  "; ?></td>

<td><?php echo $perc*$row["number"]."  "; ?></td>
<td><?php echo $row["date_to_sales"]."  "; ?></td>
</tr>   
<?php
}}
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