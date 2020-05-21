
<?php

include_once "header.php";
if($_SESSION["mystatus"]!=0){
  $month = date('n'); 
  $curday = date('y-m-d');
  $day = date('Y-m-d');
?>

<div class="alert alert-danger"  role="alert">
عرض المبيعات للوجبات والاصناف اجماليا ليوم
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
  <th>بيان الصنف</th>
  <th>عدد الوجبات</th>
  <th> استهلاك خامات </th>
  <th>قيمة اهلاكات ( التنظيف والتسويه )</th>
  <th>اجمالى استهلاك خامات </th>
</tr>
<thead>
<tbody>
<?php 

$sql99 = "
    SELECT distinct(items_hscode)
    FROM itemssales
    WHERE date(date_to_store) = '$curday'; 
" ;
$result99 = mysqli_query($conn, $sql99);
if (mysqli_num_rows($result99) > 0) {
  // output data of each row
  while($row99 = mysqli_fetch_assoc($result99)) {
      $allnumber = 0;
      $usedunit = 0;
      /////////////////
        $items_hscode = $row99['items_hscode']; 
       
      
        $sql = "
        SELECT items.name,items.dest,itemssales.san_code,itemssales.number AS allnumber,itemssales.items_hscode,itemssales.number,itemssales.date_to_store
        FROM itemssales
        INNER JOIN  items ON items.hscode = itemssales.items_hscode 
        WHERE itemssales.items_hscode = '$items_hscode'  AND  date(date_to_store) = '$curday'; 
        ";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
        
          // output data of each row
          while($row = mysqli_fetch_assoc($result)) {
            $name =  $row['name'];
            $san_code = $row['san_code'];
            $allnumber += $row['allnumber'];
            $alone = $row['allnumber'];
            $dest = $row['dest'];
            $sql2 = "
        SELECT percentage
        FROM itemssan
        WHERE items_hscode = '$items_hscode' AND san_code = '$san_code'

        ";
        $result2 = mysqli_query($conn, $sql2);
        if (mysqli_num_rows($result2) > 0) {
          // output data of each row
          while($row2 = mysqli_fetch_assoc($result2)) {
             $percentage = $row2['percentage'];
             // echo "hscode: ".$items_hscode."  sancode : ".$san_code." percentage: ".$percentage."<br/>";
              $usedunit +=$alone*$percentage;  
          }}
        }

          } 


      ////////////////////
?>
      <tr>
        <td><?php echo $name; ?></td>
        <td><?php echo $allnumber; ?></td>
        <td><?php echo $usedunit; ?></td>
        <td><?php echo $usedunit*$dest; ?></td>
        <td><?php echo $usedunit+($usedunit*$dest); ?></td>
        </tr>  
<?php
  }}

  
  else {
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
