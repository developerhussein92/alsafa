<?php
    include "header.php";
    if($_SESSION["mystatus"]!=0){
    if (isset($_GET['del'])) {
        $id = $_GET['findhscode'];
        
        $sql = "DELETE FROM supplier WHERE id=$id";
    
        if ($conn->query($sql) === TRUE) {
          echo '<div  id="test" class="alert alert-warning"  role="alert">
               تم الحذف بنجاح 
        </div>  
        
         
        ';
        } else {
           
        }
    
      }

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $txt = $_POST['txt'];
        
        echo '<div class="alert alert-warning"  role="alert">
       لقد بحثت عن (<span style="color:red">'.$txt.'</span>) 
     </div>';
        $sql = "
                SELECT *
                FROM supplier
                WHERE name like '%$txt%' OR code like '%$txt%'
                ";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {

                    ?>
                    <table style="margin-top:50px;" class="table table-hover table-bordered table-striped table-dark">  
                    <thead style="">
                    <tr>
                    <th>اسم المورد</th>
                    <th>كود المورد</th>
                    <th>تليفون المورد</th>
                    <th>فاكس المورد</th>
                    <th>ايميل المورد</th>
                    <th>عنوان المورد</th>
                    <th>العمليات</th>
                    </tr>
                    <thead>
                    <tbody>
                    <?php
                    // output data of each row
                     while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
<td><?php echo $row["name"]."    " ; ?></td>
<td><?php echo $row["code"]."  "; ?></td>
<td><?php echo $row["phone"]."  "; ?></td>
<td><?php echo $row["fax"]."  "; ?></td>
<td><?php echo $row["email"]."  "; ?></td>
<td><?php echo $row["address"]."  "; ?></td>
<td  style="width:180px;text-align:center">
    
   <form action="supplierprocess.php" method="GET"> 
    <input style="margin-left:20px" class="btn btn-danger" name="del" type="submit" value="حذف " />
    <input type="hidden" name= "findhscode" value="<?php echo $row["id"]?>"/>
    <input class="btn btn-secondary" type="submit" name="edit" value="تعديل "  formmethod = "POST" formaction="supplieredit.php"/>
  </form>
   
</td>
</tr>      
                            
                            
                            
                            
                            <?php
                        }
                        
                    }
                   

    }

?>
</tbody>
</table>

<div class="alert alert-danger"  role="alert">
بحث عن مورد
</div>

    <form  class="searchclass"  method="POST" action="suppliersearch.php">
        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white" class="input-group-text" id="basic-addon2">ابحث بااسم المورد او الكود الخاص به </span>
            </div>
            <input type="text" name="txt" class="form-control btn-lg w-50" placeholder="" aria-label="Recipient's username" aria-describedby="basic-addon2">
        
        </div>

       
        <button type="submit" style="margin-bottom:50px" class="btn btn-outline-success btn-lg w-50">بحث</button>
    </form>

    

  <?php 
    }else{
        echo ' <script> window.location.href = "index.php"; </script>';
      }
      include_once "footer.php";
    ?>