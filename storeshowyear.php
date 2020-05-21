<?php 
      include_once "header.php";
      if($_SESSION["mystatus"]!=0){
      $month = date('n'); 
?>
    <div class="alert alert-danger"  role="alert">
    عرض المخذون لسنة
    <?php $y = date('Y');
        echo $y." تفصيليا";
        ?>

    </div>


<form>
<table class="table table-hover table-bordered table-striped table-dark"> 
<thead>
    <tr>
        <th>HSCODE</th>
        <th>اسم الصنف</th>
        <th>رصيد اول المدة </th>
        <td>الوارد </td>
        <td>رقم فاتورة الوارد</td>
        <th>مبيعات</th>
        <th>محول للمطبخ</th>
        <th>رصيد أخر</th>
        <th>ملاحظات</th>
        <th>تاريخ اضافه للمخزون</th>      
    </tr>
</thead>
<tbody>
<?php 
    $myday = date('Y-m-d');
    $start = date('Y-01-01');  
    $end = date('Y-12-d 23:59:59');
    $sql = "
    SELECT items.name,items.hscode,store.pre_account,store.income_id,store.sales,store.kitchen,store.other_account,store.notes,store.date_to_store
    FROM store
    INNER JOIN items ON store.items_hscode = items.hscode
    WHERE store.date_to_store BETWEEN '$start' AND '$end'
    ORDER BY items.hscode,store.date_to_store ASC;
        ";
    $result = mysqli_query($conn, $sql);
    $x=0;
    $preacc = 0;
    $income=0;
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $income_id = $row['income_id']; 
            $sql2 = "SELECT * FROM income WHERE id='$income_id'";
            $result2 = mysqli_query($conn, $sql2);
            if (mysqli_num_rows($result2) > 0) {
                // output data of each row
                while($row2 = mysqli_fetch_assoc($result2)) {
                    $income_value = $row2['account'];
                    $income_report = $row2['report'];
                }}else{
                    $income_value = "لايوجد وارد"; 
                    $income_report = "لا يوجد";

                }
                    
?>
<tr>
            <td style="background-color:#291b1b;font-family: monospace;font-size:20px"><?php echo $row['hscode']; ?></td>
            <td style="background-color:#291b1b;font-family: monospace;font-size:20px"><?php echo $row['name']; ?></td>
            <td style="width:100px"><?php echo $row['pre_account']; ?></td>
            <td style="width:100px"><?php echo $income_value; ?></td>
            <td style="width:100px"><?php echo $income_report; ?></td>
            <td style="width:100px"><?php echo $row['sales']; ?></td>
            <td style="width:100px"><?php echo $row['kitchen']; ?></td>
            <td style="width:100px"><?php echo $row['other_account']; ?></td>
            <td style="width:100px"><?php echo $row['notes']; ?></td>
            <td style="width:100px"><?php echo $row['date_to_store']; ?></td>

</tr>   
<?php
 $x++;
        }
        } else {
            echo '<div class="alert alert-warning"  role="alert">
            لا توجد عناصر 
         </div>';
        }

?>
</tbody>
 </table>
 <?php 
  }else{
    echo ' <script> window.location.href = "index.php"; </script>';
  }
      include_once "footer.php";
?>