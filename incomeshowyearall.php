<?php   include_once "header.php"; if($_SESSION["mystatus"]>=2){?>

  

    <div class="alert alert-danger"  role="alert">
    عرض قائمة الاسعار لسنة
    <?php $y = date('Y');
        echo $y." اجماليا";
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
    
    $start = date('Y-m-01');  
    $end = date('Y-12-d 23:59:59');
    $sql = "
    SELECT items.name,items.hscode,SUM(store.pre_account) AS pre_account,SUM(store.income) AS income,SUM(store.sales) AS sales,SUM(store.kitchen) AS kitchen
    ,SUM(store.other_account) AS other_account,(SUM(store.income)+SUM(store.pre_account))-(SUM(store.sales)+SUM(store.kitchen)+SUM(store.other_account)) AS play
    FROM store
    INNER JOIN items ON store.items_hscode = items.hscode
    WHERE store.date_to_store BETWEEN '$start' AND '$end'
    GROUP BY items.hscode;
        ";
    $result = mysqli_query($conn, $sql);
    $x=0;
    $preacc = 0;
            $income=0;
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
?>
<tr>
            <td style="background-color:#291b1b;font-family: monospace;font-size:20px"><?php echo $row['hscode']; ?></td>
            <td style="background-color:#291b1b;font-family: monospace;font-size:20px" ><?php echo $row['name']; ?></td>
            <td style="width:100px"><?php echo $row['pre_account']; ?></td>
            <td style="width:100px"><?php echo $row['income']; ?></td>
            <td style="width:100px"><?php echo $row['sales']; ?></td>
            <td style="width:100px"><?php echo $row['kitchen']; ?></td>
            <td style="width:100px"><?php echo $row['other_account']; ?></td>
            <td style="width:100px"><?php echo $row['play']; ?></td>
</tr>   
<?php
 $x++;
        }
        } else {
        echo "0 results";
        }
?>
 </table>
 <?php 
 }else{
    echo ' <script> window.location.href = "index.php"; </script>';
}
      include_once "footer.php";
?>