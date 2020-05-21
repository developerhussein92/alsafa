<?php 
      include_once "header.php";
      if($_SESSION["mystatus"]>=2){
      $month = date('n'); 

      if (isset($_GET['del'])) {
         $id = $_GET['findhscode'];
        
        $sql = "DELETE FROM income WHERE report='$id'";
    
        if ($conn->query($sql) === TRUE) {
          echo '<div  id="test" class="alert alert-warning"  role="alert">
               تم الحذف بنجاح 
        </div>  
        
         
        ';
        } else {
           
        }
    
      }
?>

<form  class="searchclass"  method="POST" action="incomereportsearch.php" style="width:1200px;margin:auto auto">
        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span  style="background-color:black;color:white" class="input-group-text" id="basic-addon2">ابحث برقم الفاتورة </span>
            </div>
            <input required type="text" name="txt" class="form-control btn-lg w-50" placeholder="" aria-label="Recipient's username" aria-describedby="basic-addon2">
        
        </div>
       
        <button type="submit" style="margin-bottom:50px" class="btn btn-outline-success btn-lg w-50">بحث</button>
</form>

    <div class="alert alert-danger"  role="alert">
     بحث عن قائمة الاسعار برقم الفاتورة
    
    </div>

<form>

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
</tr>
<thead>
<tbody>
<?php 
 
 if ($_SERVER['REQUEST_METHOD'] === 'POST')
 {
     $txt = $_POST['txt'];
     $all = 0;
     
     echo '<div class="alert alert-warning"  role="alert">
    لقد بحثت عن (<span style="color:red">'.$txt.'</span>) 
  </div>';

$sql = "
SELECT items.name,income.account,income.buy_price,income.value,income.sell_price,income.percentage,income.date_to_income,income.report
FROM income
INNER JOIN items ON income.items_hscode = items.hscode
WHERE income.report = '$txt' 
ORDER BY items.hscode,income.date_to_income
";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {?>
  <button type="submit" name="del" style="margin-bottom:50px" class="btn btn-outline-danger btn-lg w-100">حذف الفاتوره</button>
  <input type="hidden" name= "findhscode" value="<?php echo $txt?>"/>
 <?php // output data of each row
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
          <td style="font-family: monospace;font-size:20px">اجمالي القيمه</td>
          <td colspan="7" style="text-align:center;font-size:22px;"><?php  echo $all."  ";?>جنيها</td>
      </tr>
</tfoot>
</table>

</form>
<?php
 }/////////////////////////////
}else{
  echo ' <script> window.location.href = "index.php"; </script>';
}
  include_once "footer.php";
?>