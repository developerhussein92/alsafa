<?php
        include "header.php";
        if($_SESSION["mystatus"]!=0){
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $name = $_POST['name'];
        $hscode = $_POST['hscode'];
        $dest = $_POST['dest'];
        $state = 0 ;

        $sql = "
                SELECT *
                FROM items
                ";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                            if($name == $row['name'])
                            {
                                echo '<div class="alert alert-warning"  role="alert">
                                  هناك صنف بنفس الاسم'.'  <span style="color:red;font-weight:bold">'.$name.'
                             </span></div>';
                            
                                $state = 1;
                            }else if($hscode == $row['hscode']){
                                echo '<div class="alert alert-warning"  role="alert">
                                هناك صنف بنفس الكود'.'  <span style="color:red;font-weight:bold">'.$hscode.'
                           </span></div>';
                                $state = 1;
                            }
                            
                               
                            
                        }
                        
                    }
                    if($state == 0 )
                    {
                        $sql = "INSERT INTO items (hscode, name,dest)
                        VALUES ('$hscode', '$name',$dest)";
                        if (mysqli_query($conn, $sql)) {
                            echo '
                            <script>
            
                            window.location.href = "itemsshow.php";
                            </script>
            
                            ';
                          
                        } else {
                            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        }
                    }

    }

?>


<div class="alert alert-danger"  role="alert">
أضافة صنف 
</div>

    <form method="POST" action="itemsadd.php">
        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white" class="input-group-text" id="basic-addon2">اسم الصنف</span>
            </div>
            <input type="text" name="name" class="form-control btn-lg w-50"  aria-label="Recipient's username" aria-describedby="basic-addon2">
        
        </div>

        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white"  class="input-group-text" id="basic-addon2">HSCODE</span>
            </div>
            <input type="text" class="form-control btn-lg w-50" name="hscode"  aria-label="Recipient's username" aria-describedby="basic-addon2">
        
        </div>

        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white"  class="input-group-text" id="basic-addon2">قيمة اهلاكات ( التنظيف والتسويه )</span>
            </div>
            <input type="text" class="form-control btn-lg w-50" name="dest"  aria-label="Recipient's username" aria-describedby="basic-addon2">
        
        </div>  

        <button type="submit" class="btn btn-outline-success btn-lg w-50">أضف</button>
    </form>

    

  <?php 
  }else{
    echo ' <script> window.location.href = "index.php"; </script>';
  }
      include_once "footer.php";
    ?>