<?php
        include "header.php";
        if($_SESSION["mystatus"]>=2){
        if (isset($_POST['runedit']))
        {
                $id = $_POST['id'];
                $account = $_POST['account'];
                $buy_price = $_POST['buy_price'];
                $percentage = $_POST['percentage'];
                @$value = $account*$buy_price;
                @$sell_price = $buy_price+($buy_price*($percentage/100));
              
                
            $sql = 
            "
            UPDATE income
            SET 
            account = '$account', 
            buy_price= '$buy_price',
            percentage= '$percentage',
            value= '$value',
            sell_price= '$sell_price'
            WHERE id = '$id';
            "
            ;

            if ($conn->query($sql) === TRUE) {
               echo $id;
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
                    $income_value = $account;
                    $sales = $row2['sales'];
                    $kitchen = $row2['kitchen'];
                    @$other = ($income_value + $pre)-($sales+$kitchen);
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
                echo '<script>window.location.href = "incomeshowdayprocess.php";</script>';
                echo '<div  id="test" class="alert alert-warning"  role="alert">
                تم الحفظ بنجاح 
         </div>  ';
            } else {
              
            }
        }

    if (isset($_POST['findhscode']))
    {
       
         $hscode = $_POST['findhscode'];
         $name = $_POST['name'];
        
        $sql = "
        SELECT *
         FROM income
         WHERE id  = $hscode
        ";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
?>
<div class="alert alert-danger"  role="alert">
تعديل قائمة الاسعار  <span style="color:green;font-weight:bold"><?php echo $name ?></span>  
</div>
    <form method="POST" action="incomeedit.php">
    <input type="hidden" name="id" value="<?php echo$row['id'];?>"/>
        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white" class="input-group-text" id="basic-addon2">اسم الصنف</span>
            </div>
            <input type="text" readonly  value="<?php echo $name?>" class="form-control btn-lg w-50" placeholder=" اسم الصنف" aria-label="Recipient's username" aria-describedby="basic-addon2">
        </div>

        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white"  class="input-group-text" id="basic-addon2">ادخل قيمة الوارد</span>
            </div>
            <input type="text"  class="form-control btn-lg w-50" name="account" value="<?php echo $row['account'];?>"  placeholder="" aria-label="Recipient's username" aria-describedby="basic-addon2">     
        </div>  

             <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white"  class="input-group-text" id="basic-addon2">ادخل سعر الشراء</span>
            </div>
            <input type="text"  class="form-control btn-lg w-50" name= "buy_price" value="<?php echo $row['buy_price'];?>"  placeholder="" aria-label="Recipient's username" aria-describedby="basic-addon2">     
        </div>    


             <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white"  class="input-group-text" id="basic-addon2">ادخل النسبه للوارد</span>
            </div>
            <input type="text"  class="form-control btn-lg w-50" name ="percentage" value="<?php echo $row['percentage'];?>"  placeholder=" " aria-label="Recipient's username" aria-describedby="basic-addon2">     
        </div>   

       

       

        
        <button type="submit" name="runedit" style="margin-bottom:120px" class="btn btn-outline-success btn-lg w-50">حفظ التعديل</button>
    </form>
  <?php 
            }}}
        }else{
            echo ' <script> window.location.href = "index.php"; </script>';
        }
      include_once "footer.php";
    ?>