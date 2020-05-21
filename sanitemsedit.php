<?php
        include "header.php";
        if($_SESSION["mystatus"]!=0){
        if (isset($_POST['runedit']))
        {
               $id = $_POST['id'];
                $name = $_POST['name'];
                $code = $_POST['code'];
               $percentage =$_POST['percentage'];
              
            $sql = 
            "
            UPDATE itemssan
            SET percentage = '$percentage'
            WHERE id = '$id';
            "
            ;

            if ($conn->query($sql) === TRUE) {
               echo '
                            <script>
            
                            window.location.href = "sanadditems.php?code='.$code.'&&name='.$name.'";
                            </script>
            
                            ';
               
                echo '<div  id="test" class="alert alert-warning"  role="alert">
                تم الحفظ بنجاح 
         </div>  ';
            } else {
              
            }
        }

    if (isset($_POST['findhscode']))
    {
       
        $id = $_POST['findhscode'];
        
        $sql = "
        SELECT *
         FROM itemssan
         WHERE id  = '$id'
        ";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {

?>


<div class="alert alert-danger"  role="alert">
تعديل نسبه صنف 
 <span style="color:red"><?php echo $_POST['realname'];?></span> 
 داخل وجبة 
 <span style="color:red"><?php echo $_POST['name'];?></span>
</div>

    <form method="POST" action="sanitemsedit.php">
    <input type="hidden" name="id" value="<?php echo $row['id'];?>"/>
    <input type="hidden" name="name" value="<?php echo  $_POST['name'];?>"/>
    <input type="hidden" name="code" value="<?php echo $row['san_code'];?>"/>
        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white" class="input-group-text" id="basic-addon2">تعديل النسبة الحالية</span>
            </div>
            <input type="text" name="percentage" value="<?php echo $row['percentage']?>" class="form-control btn-lg w-50" placeholder="ادخل اسم الصنف" aria-label="Recipient's username" aria-describedby="basic-addon2">
        
        </div>
  
        <button type="submit" name="runedit" class="btn btn-outline-success btn-lg w-50">حفظ التعديل</button>
    </form>

    

  <?php 
            }}}
        }else{
            echo ' <script> window.location.href = "index.php"; </script>';
          }
      include_once "footer.php";
    ?>