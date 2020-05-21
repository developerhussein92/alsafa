<?php
    include_once "header.php";
    if($_SESSION["mystatus"]>=2){
        $curday = date('y-m-d');
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        
        for($x=0;$x<count( $_POST['items']);$x++)
        {
              $items_hscode = $_POST['items'][$x];
              $account = $_POST['account'][$x];
              @$buy_price = $_POST['buy_price'][$x];
              @$value = $account*$buy_price;
              $percentage = $_POST['percentage'][$x];
              @$sell_price = $buy_price+($buy_price*($percentage/100));
              $date_to_income = date("Y-m-d h:m:s");
              $report = $_POST['report'];
              $supplier_id = $_POST['supplier_id'];

            $sql = "
            INSERT INTO income (items_hscode, account,buy_price,value,sell_price,percentage,date_to_income,report,supplier_id)
                        VALUES (
                            '$items_hscode',
                            '$account',
                            '$buy_price',
                            '$value',
                            '$sell_price',
                            '$percentage',
                            '$date_to_income',
                            '$report',
                            '$supplier_id'
                            )";
                            if($account != 0 && $buy_price != 0)
                            {
                                $sql2 = "
                                SELECT * 
                                FROM income 
                                WHERE items_hscode = '$items_hscode' AND date_to_income  = '$curday';
                                ";
                                $result2 = mysqli_query($conn, $sql2);
                                if (mysqli_num_rows($result2) > 0) {
                                    // output data of each row
                                    while($row2 = mysqli_fetch_assoc($result2)) {
                                          
                                    }
                                }else{
                                        if (mysqli_query($conn, $sql)) {
                                            /*********** */
                                                $income_id = $conn->insert_id;
                                                $income_value =  $account;

                                                $sql3 = "
                                                SELECT * 
                                                FROM store
                                                WHERE items_hscode = '$items_hscode' AND date_to_store = '$curday';
                                                ";
                                                $result3 = mysqli_query($conn, $sql3);
                                                if (mysqli_num_rows($result3) > 0) {
                                                    // output data of each row
                                                    while($row3 = mysqli_fetch_assoc($result3)) {
                                                          //##########
                                                          $pre = $row3['pre_account']."<br/>";
                                                          $income_value = $account."<br/>";
                                                           $sales = $row3['sales']."<br/>";
                                                          $kitchen = $row3['kitchen']."<br/>";
                                                          @$other = ($pre+$income_value)-($sales+$kitchen);
                                                          $sql3 = "
                                                          UPDATE store
                                                          SET 
                                                          income_id = '$income_id',
                                                          other_account = '$other'
                                                          WHERE items_hscode  = '$items_hscode';
                                                          "; 
                                                          if ($conn->query($sql3) === TRUE) {
                                                            
                                                          }else
                                                          {
                                                             
                                                          }
                                      
                                      
                                                         


                                                          //############
                                                    }}



                                            /*********** */
                                            echo '<script> window.location.href = "incomeshowday.php";</script>';
                                           } else {
                                         echo '<div class="alert alert-danger"  role="alert">
                                         مشكله في التخزين  
                                         </div>';
                                           }
                                    }

                                
                            }
            }  
    }else
    {      
    }
?>
<form action="incomeadd.php" method="POST">
   
    <div class="alert alert-danger"  role="alert">
    اضافه قائمة الاسعار 
    </div>
<form style="margin-bottom:200px">
<table class="table table-hover table-bordered table-striped table-dark">
    <thead>
    <tr>
        <th>اسم الصنف</th>
        <th>وارد</th>
        <th>سعر الشراء</th>
        <th>النسبة</th>
    </tr>
</thead>
<tbody>
<?php 
        include_once "conn.php";
    $sql = "SELECT * FROM items";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
?>
<tr>
<td><?php echo $row["name"]; ?></td>
<input type="hidden" value="<?php echo $row["hscode"]; ?>" name="items[]"/>
<td><input type="text" name="account[]"  /></td>
<td><input  type="text" name="buy_price[]" /></td>
<td><input  type="text" name="percentage[]"  /></td>
</tr>   
<?php
        }
        } else {
        echo "0 results";
        }
?>
</tbody>
 </table>
 <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white" class="input-group-text" id="basic-addon2">ادخل رقم الفاتورة</span>
            </div>
            <input required type="text" style="border:1px solid #ac42b3;" class="form-control btn-lg w-50" name="report" aria-label="Recipient's username" aria-describedby="basic-addon2">     
 </div>



 <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white" class="input-group-text" id="basic-addon2">اختر اسم المورد</span>
            </div>
            <select required style="border:1px solid #ac42b3;min-height:50px" class="form-control btn-lg w-50" name="supplier_id" aria-label="Recipient's username" aria-describedby="basic-addon2">
 <?php
 $sql = "SELECT * FROM supplier";
 $result = mysqli_query($conn, $sql);
 if (mysqli_num_rows($result) > 0) {
     // output data of each row
     while($row = mysqli_fetch_assoc($result)) {
 ?>
<option name="supplier_id" value ="<?php echo $row['id']?>" ><?php echo $row['name']?></option>

<?php
     }}
?>
</select>
</div>
 <button class="btn btn-primary w-50 lop" style="margin-bottom:100px;position: relative;margin-bottom: 100px; margin-left: 245px;right: -531px;" >اضافة الوارد</button>
 </form>
 <?php
 }else{
    echo ' <script> window.location.href = "index.php"; </script>';
}
    include_once "footer.php";
?>