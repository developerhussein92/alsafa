<?php
        include "header.php";
        if($_SESSION["mystatus"]!=0){
        if (isset($_POST['runedit']))
        {
               $id = $_POST['id'];
               $name =$_POST['name'];
               $hscode =$_POST['hscode'];
               $dest =$_POST['dest'];
              
            $sql = 
            "
            UPDATE items
            SET name = '$name', hscode= '$hscode' ,dest = $dest
            WHERE hscode = '$id';
            "
            ;

            if ($conn->query($sql) === TRUE) {
                echo '
                            <script>
            
                            window.location.href = "itemsprocess.php";
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
       
        $hscode = $_POST['findhscode'];
        
        $sql = "
        SELECT *
         FROM items
         WHERE hscode  = $hscode
        ";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {

?>


<div class="alert alert-danger"  role="alert">
تعديل صنف 
</div>

    <form method="POST" action="itemsedit.php">
    <input type="hidden" name="id" value="<?php echo $row['hscode'];?>"/>
        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white" class="input-group-text" id="basic-addon2">اسم الصنف</span>
            </div>
            <input type="text" name="name" value="<?php echo $row['name']?>" class="form-control btn-lg w-50" placeholder="ادخل اسم الصنف" aria-label="Recipient's username" aria-describedby="basic-addon2">
        
        </div>

        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white"  class="input-group-text" id="basic-addon2">HSCODE</span>
            </div>
            <input type="text" class="form-control btn-lg w-50"value="<?php echo $row['hscode'];?>" name="hscode" placeholder="ادخل كود العنصر" aria-label="Recipient's username" aria-describedby="basic-addon2">
        
        </div>    

        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white"  class="input-group-text" id="basic-addon2">قيمة اهلاكات ( التنظيف والتسويه )</span>
            </div>
            <input type="text" class="form-control btn-lg w-50"value="<?php echo $row['dest'];?>" name="dest" placeholder="ادخل كود العنصر" aria-label="Recipient's username" aria-describedby="basic-addon2">
        
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