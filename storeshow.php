<?php 
      include_once "header.php";
      if($_SESSION["mystatus"]!=0){
?>


    
    <div class="alert alert-danger"  role="alert">
            عرض المخزون اليومي  
    </div>

<form>
<table class="table table-hover table-bordered table-striped table-dark">  
<thead style="">
    <tr>
        <th>HSCODE</th>
        <th>اسم الصنف</th>
        <th>رصيد اول المدة </th>
        <th>وارد</th>
        <th>مبيعات</th>
        <th>محول للمطبخ</th>
        <th>رصيد أخر</th>
        <th>ملاحظات</th>
        <th>تاريخ اضافه للمخزون</th>
        
        
    </tr>
</thead>
<tbody>
<?php 
    
    $sql = "
    SELECT items.name,items.hscode,store.pre_account,store.income,store.sales,store.kitchen,store.other_account,store.notes,store.date_to_store
    FROM store
    INNER JOIN items ON store.items_hscode = items.hscode
    

        ";
    $result = mysqli_query($conn, $sql);
    $x=0;
    $preacc = 0;
            $income=0;
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            
            $preacc += $row['pre_account']; 
            $income += $row['income'];
            

?>
<tr>
            <td   style="background-color:#291b1b;font-family: monospace;font-size:20px"><?php echo $row['hscode']; ?></td>
            <td   style="background-color:#291b1b;font-family: monospace;font-size:20px"><?php echo $row['name']; ?></td>
            <td style="width:100px"><?php echo $row['pre_account']; ?></td>
            <td style="width:100px"><?php echo $row['income']; ?></td>
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