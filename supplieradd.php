<?php
        include "header.php";
        if($_SESSION["mystatus"]!=0){
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $name = $_POST['name'];
        $code = $_POST['code'];
        $phone =$_POST['phone'];
        $fax =$_POST['fax'];
        $email =$_POST['email'];
        $address =$_POST['address'];
        $state = 0 ;

        $sql = "
                SELECT *
                FROM supplier
                ";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                            if($name == $row['name'])
                            {
                                echo '<div class="alert alert-warning"  role="alert">
                                  هناك مورد بنفس الاسم'.'  <span style="color:red;font-weight:bold">'.$name.'
                             </span></div>';
                            
                                $state = 1;
                            }else if($code == $row['code']){
                                echo '<div class="alert alert-warning"  role="alert">
                                هناك مورد بنفس الكود'.'  <span style="color:red;font-weight:bold">'.$code.'
                           </span></div>';
                                $state = 1;
                            }
                            
                               
                            
                        }
                        
                    }
                    if($state == 0 )
                    {
                        $sql = "INSERT INTO supplier (name, code,phone,fax,email,address)
                        VALUES ('$name', '$code','$phone','$fax','$email','$address')";
                        if (mysqli_query($conn, $sql)) {
                            echo ' <script> window.location.href = "suppliershow.php"; </script>';
                          
                        } else {
                            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        }
                    }

    }

?>


<div class="alert alert-danger"  role="alert">
اضافة مورد جديد 
</div>

    <form method="POST" action="supplieradd.php">
        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white" class="input-group-text" id="basic-addon2">Name</span>
            </div>
            <input type="text" name="name" class="form-control btn-lg w-50" placeholder="ادخل اسم المورد" aria-label="Recipient's username" aria-describedby="basic-addon2">
        
        </div>

        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white"  class="input-group-text" id="basic-addon2">CODE</span>
            </div>
            <input type="text" class="form-control btn-lg w-50" name="code" placeholder="ادخل كود المورد" aria-label="Recipient's username" aria-describedby="basic-addon2">
        
        </div>    

        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white"  class="input-group-text" id="basic-addon2">Phone</span>
            </div>
            <input type="text" class="form-control btn-lg w-50" name="phone" placeholder="ادخل رقم الموبايل " aria-label="Recipient's username" aria-describedby="basic-addon2">
        
        </div>  

        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white"  class="input-group-text" id="basic-addon2">Fax</span>
            </div>
            <input type="text" class="form-control btn-lg w-50" name="fax" placeholder="ادخل رقم الفاكس" aria-label="Recipient's username" aria-describedby="basic-addon2">
        
        </div>  

        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white"  class="input-group-text" id="basic-addon2">Email</span>
            </div>
            <input type="email" class="form-control btn-lg w-50" name="email" placeholder="ادخل الايميل" aria-label="Recipient's username" aria-describedby="basic-addon2">
        
        </div>  

        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white"  class="input-group-text" id="basic-addon2">Address</span>
            </div>
            <input type="text" class="form-control btn-lg w-50" name="address" placeholder="ادخل العنوان" aria-label="Recipient's username" aria-describedby="basic-addon2">
        
        </div>  
        <button type="submit" class="btn btn-outline-success btn-lg w-50">أضف</button>
    </form>

    

  <?php 
  }else{
    echo ' <script> window.location.href = "index.php"; </script>';
  }
      include_once "footer.php";
    ?>