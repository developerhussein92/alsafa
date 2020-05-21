<?php 
      include_once "header.php";
      if($_SESSION["mystatus"]!=0){
      $month = date('n'); 
?>
    <div class="alert alert-danger"  role="alert">
    عرض المخزون لشهر 
    <?php 
      
        $m = $armonth[$month-1];
        $y = date('Y');
        echo $m." - ".$y." اجماليا";
    
    ?>  
    </div>

<form>
<table class="table table-hover table-bordered table-striped table-dark"> 
<thead>
    <tr>
        <th>HSCODE</th>
        <th>اسم الصنف</th>
        <th>رصيد اول المدة </th>
        <th>وارد</th>
        <th>مبيعات</th>
        <th>محول للمطبخ</th>
        <th>رصيد أخر</th>
        <th>الاستهلاك الفعلي</th>
    </tr>
</thead>
<tbody>
<?php 
       
       $sql99 = "
       SELECT *
        FROM items
       ";
       $result99 = mysqli_query($conn, $sql99);
       if (mysqli_num_rows($result99) > 0) {
           // output data of each row
           while($row99 = mysqli_fetch_assoc($result99)) {
            $items_hscode = $row99['hscode'];
            //////////////////////////
            

    $start = date('Y-m-01');  
    $end = date('Y-m-d 23:59:59');
    $sql = "
    SELECT *
    FROM store
    WHERE items_hscode = '$items_hscode' AND date(date_to_store) BETWEEN '$start' AND '$end' ;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
       $income_value=0;
       $pre = 0;
       $sales =0;
       $kitchen = 0;
       $other = 0;
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $income_id =  $row['income_id'];
            $pre += $row['pre_account'];
            $sales += $row['sales'];
            $kitchen += $row['kitchen'];
            $other += $row['other_account'];
            if($row['income_id'] == null )
            {
              
            }else{
                $sql3 = "
                SELECT account 
                from income 
                WHERE id = '$income_id';
                ";
                $result3 = mysqli_query($conn, $sql3);
                if (mysqli_num_rows($result3) > 0) {
                     while($row3 = mysqli_fetch_assoc($result3)) {
                        $income_value +=$row3['account']; 
                     }
                     }
            }
           
            }
        } 
            ///////////////////////////
?>
            <tr>
            <td style="background-color:#291b1b;font-family: monospace;font-size:20px"><?php echo $row99['hscode']; ?></td>
            <td style="background-color:#291b1b;font-family: monospace;font-size:20px"><?php echo $row99['name']; ?></td>
            <td style="width:100px"><?php echo $pre; ?></td>
            <td style="width:100px"><?php echo $income_value; ?></td>
            <td style="width:100px"><?php echo $pre; ?></td>
            <td style="width:100px"><?php echo $sales; ?></td>
            <td style="width:100px"><?php echo $kitchen; ?></td>
            <td style="width:100px"><?php echo ($pre+$income_value)-($sales+$kitchen+$other); ?></td>
</tr>   
</tbody>

<?php
           }
           }

?>

 </table>
 <?php 
  }else{
    echo ' <script> window.location.href = "index.php"; </script>';
  }
      include_once "footer.php";
?>