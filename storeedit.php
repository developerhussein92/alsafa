<?php
        include "header.php";
        if($_SESSION["mystatus"]!=0){
            $curday = date('y-m-d');
        if (isset($_POST['runedit']))
        {
                $id = $_POST['id'];
                $pre = $_POST['pre'];
                $income_value = $_POST['income_value'];
                $income_id = $_POST['income_id'];
                $sales = $_POST['sales'];
                $kitchen = $_POST['kitchen'];
                $notes = $_POST['notes'];
                @$other = ($income_value + $pre)-($sales+$kitchen);

                if($income_id == null)
                {
                    $income_id = "null";
                   
                }else
                {
                    $income_id = "'".$income_id."'"; 
                }
              
              
            $sql = 
            "
            UPDATE store
            SET 
            pre_account = '$pre', 
            income_id = $income_id,
            sales= '$sales',
            kitchen= '$kitchen',
            other_account= '$other',
            notes= '$notes'
            WHERE id = '$id';
            "
            ;

            if ($conn->query($sql) === TRUE) {
                echo '
                <script>

                window.location.href = "storeshowdayprocess.php";
                </script>

                ';

               
                echo '<div  id="test" class="alert alert-warning"  role="alert">
                تم الحفظ بنجاح 
         </div>  ';
            } else {
              echo "error update";
            }
        }

    if (isset($_POST['findhscode']))
    {
       
         $hscode = $_POST['findhscode'];
         $items_hscode = $_POST['hscode'];
         $name = $_POST['name'];
        
        $sql = "
        SELECT *
         FROM store
         WHERE id  = '$hscode'
        ";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                 $income_id = $row['income_id'];

                $sql2 = "
        SELECT *
         FROM income
         WHERE items_hscode  = '$items_hscode' AND date_to_income = '$curday' 
        ";
        $result2 = mysqli_query($conn, $sql2);
        if (mysqli_num_rows($result2) > 0) {
            // output data of each row
            while($row2 = mysqli_fetch_assoc($result2)) {
                $income_value = $row2['account'];
                 $income_id = $row2['id'];
            }}else{ $income_value=0;$income_id=null;}
?>
<div class="alert alert-danger"  role="alert">
تعديل صنف <span style="color:green;font-weight:bold"><?php echo $name ?></span> بالمخزون 
</div>
    <form method="POST" action="storeedit.php">
    <input type="hidden" name="id" value="<?php echo $row['id'];?>"/>
    
    <input type="hidden" name="income_id" value="<?php echo $income_id?>"/>
        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white" class="input-group-text" id="basic-addon2">اسم الصنف</span>
            </div>
            <input type="text" readonly  value="<?php echo $name?>" class="form-control btn-lg w-50" placeholder=" اسم الصنف" aria-label="Recipient's username" aria-describedby="basic-addon2">
        </div>

        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white"  class="input-group-text" id="basic-addon2">HSCODE</span>
            </div>
            <input type="text" readonly class="form-control btn-lg w-50"value="<?php echo $items_hscode;?>"  placeholder=" كود العنصر" aria-label="Recipient's username" aria-describedby="basic-addon2">     
        </div>    

        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white" class="input-group-text" id="basic-addon2">ادخل رصيد اول المدة</span>
            </div>
            <input type="text" name="pre" value="<?php echo $row['pre_account']?>" class="form-control btn-lg w-50" placeholder="" aria-label="Recipient's username" aria-describedby="basic-addon2">
        </div>

        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white" class="input-group-text" id="basic-addon2">ادخل قيمة الوارد</span>
            </div>
            <input readonly type="text" name="income_value" value="<?php echo $income_value; ?>" class="form-control btn-lg w-50" placeholder="" aria-label="Recipient's username" aria-describedby="basic-addon2">
        </div>

     

        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white" class="input-group-text" id="basic-addon2">ادخل قيمة المبيعات</span>
            </div>
            <input type="text" name="sales" value="<?php echo $row['sales']?>" class="form-control btn-lg w-50" placeholder="" aria-label="Recipient's username" aria-describedby="basic-addon2">
        </div>

        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white" class="input-group-text" id="basic-addon2">ادخل قيمة المحول للمطبخ</span>
            </div>
            <input type="text" name="kitchen" value="<?php echo $row['kitchen']?>" class="form-control btn-lg w-50" placeholder="" aria-label="Recipient's username" aria-describedby="basic-addon2">
        </div>

        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white" class="input-group-text" id="basic-addon2">قم بكتابة الملاحظات</span>
            </div>
            <textarea class="form-control w-50" id="exampleFormControlTextarea3" rows="2" name="notes"><?php echo $row['notes']?></textarea>
           
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