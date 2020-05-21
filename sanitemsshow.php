
<?php

include_once "header.php";
if($_SESSION["mystatus"]!=0){
  $month = date('n'); 
  $curday = date('y-m-d');
  $day = date('Y-m-d');
?>

<div class="alert alert-danger"  role="alert">
عرض الوجبات بالاصناف تفصيليا 
</div>
<form>
<table class="table table-hover table-bordered table-striped table-dark">  
<thead style="">
<tr>
  <th>اسم الوجبة</th>
  <th>كود الوجبة</th>
  <th>اسم الصنف</th>
  <th>كود الصنف</th>
  <th>نسبه اهلاك الصنف</th>
  <th>نسبة الصنف داخل الوجبة</th>
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
      $san_code = $row['code'];    

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
<td rowspan="<?php echo $myres;?>"><?php  echo $san_code; ?></td>

      <?php 

}}
    $sql2 = "
SELECT itemssan.items_hscode,itemssan.percentage,itemssan.san_code,items.name,items.dest
FROM itemssan
INNER JOIN  items ON itemssan.items_hscode = items.hscode 
WHERE san_code = $san_code;

";
$result2 = mysqli_query($conn, $sql2);
if (mysqli_num_rows($result2) > 0) {
  // output data of each row

  while($row2 = mysqli_fetch_assoc($result2)) {
   


?>

<td><?php echo $row2["name"]."  "; ?></td>

<td><?php echo $row2['items_hscode']; ?></td>
<td><?php echo $row2['dest']; ?></td>
<td><?php echo $row2["percentage"]."  "; ?></td>
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