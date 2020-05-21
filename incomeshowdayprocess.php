
<?php

include_once "header.php";
if($_SESSION["mystatus"]>=2){
if (isset($_GET['del'])) {
    $id = $_GET['findhscode'];
    
    $sql = "DELETE FROM income WHERE id=$id";

                           ///////////////
                           $sql2 = "
                           SELECT *
                            FROM store
                            WHERE income_id  = '$id'
                           ";
                           $result2 = mysqli_query($conn, $sql2);
                           if (mysqli_num_rows($result2) > 0) {
                               // output data of each row
                               while($row2 = mysqli_fetch_assoc($result2)) {
                                $pre = $row2['pre_account'];
                                $account = 0;
                                $sales = $row2['sales'];
                                $kitchen = $row2['kitchen'];
                                @$other = ($account + $pre)-($sales+$kitchen);
                                $sql3 = "
                                UPDATE store
                                SET 
                                other_account = '$other'
                                WHERE income_id  = '$id'
                                "; 
                                if ($conn->query($sql3) === TRUE) {}
            
            
                               }
                            }else{
                             
                            }
            
                            /////////////
    if ($conn->query($sql) === TRUE) {
      echo '<div  id="test" class="alert alert-warning"  role="alert">تم الحذف بنجاح  </div>';

      //////////



      //////////////
    } else {
       
    }

  }


$month = date('n'); 
?>

<div class="alert alert-danger"  role="alert">
تعديل قائمة الاسعار اليومية 
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
  <th>اسم الصنف</th>
  <th>وارد</th>
  <th>سعر الشراء</th>
  <th>القيمة</th>
  <th>سعر البيع</th>
  <th>النسبة</th>
  <th>تاريخ الوارد</th>
  <th>رقم الفاتورة</th>
  <th>العمليات عالوارد اليومي </th>  
</tr>
<thead>
<tbody>
<?php 
$myday = date('Y-m-d');
$sql = "
SELECT items.name,income.id,income.account,income.buy_price,income.value,income.sell_price,income.percentage,income.date_to_income,income.report
FROM income
INNER JOIN items ON income.items_hscode = items.hscode
WHERE date(income.date_to_income) = '$myday'
ORDER BY items.hscode
";
$all = 0;
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {         
      $all += $row["value"];
?>
<tr>
<td  style="background-color:#291b1b;font-family: monospace;font-size:20px"><?php echo $row["name"]; ?></td>
<td><?php echo $row["account"]."    " ; ?>كجم</td>
<td><?php echo $row["buy_price"]."  "; ?>جنيها</td>
<td><?php echo $row["value"]." " ; ?> جنيها</td>
<td><?php echo $row["sell_price"]."  "; ?>جنيها</td>
<td><?php echo $row["percentage"]."  "; ?>%</td>
<td><?php echo  $row["date_to_income"]; ?></td>
<td><?php echo  $row["report"]; ?></td>
<td  style="text-align:center;width:250px">
    
                <form action="incomeshowdayprocess.php" method="GET"> 
                    <input style="margin-left:10px;display:inline-block" class="btn btn-danger" name="del" type="submit" value="حذف " />
                    <input style="display:inline-block" type="hidden" name= "findhscode" value="<?php echo $row["id"]?>"/>
                    <input style="display:inline-block" type="hidden" name= "name" value="<?php echo $row["name"]?>"/>
                    <input style="display:inline-block" class="btn btn-secondary" type="submit" name="edit" value="تعديل "  formmethod = "POST" formaction="incomeedit.php"/>
                </form>
            
 </td>
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
<tfoot style="background-color:green">
  <tr>
      <td style="font-family: monospace;font-size:20px">اجمالي القيمه اليومية</td>
      <td colspan="8" style="text-align:center;font-size:22px;"><?php  echo $all."  ";?>جنيها</td>
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