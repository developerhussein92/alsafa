<?php
    include "header.php";
    if($_SESSION["mystatus"]!=0){
    if (isset($_GET['del'])) {
        $id = $_GET['findhscode'];
        
        $sql = "DELETE FROM items WHERE hscode=$id";
    
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
                FROM items
                WHERE name like '%$txt%' OR hscode like '%$txt%'
                ";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {

                    ?>
                    <table style="margin-top:50px;" class="table table-hover table-bordered table-striped table-dark">  
                    <thead style="">
                    <tr>
                        <th>اسم الصنف</th>
                        <th>HSCODE</th>
                        <th>قيمة اهلاكات ( التنظيف والتسويه )</th>
                        <th>العمليات</th>
                    </tr>
                    <thead>
                    <tbody>
                    <?php
                    // output data of each row
                     while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
<td><?php echo $row["name"]."    " ; ?></td>
<td><?php echo $row["hscode"]."  "; ?></td>
<td><?php echo $row["dest"]."  "; ?></td>
<td  style="text-align:center">
    
   <form action="itemsprocess.php" method="GET"> 
    <input style="margin-left:20px" class="btn btn-danger" name="del" type="submit" value="حذف العنصر" />
    <input type="hidden" name= "findhscode" value="<?php echo $row["hscode"]?>"/>
    <input class="btn btn-secondary" type="submit" name="edit" value="تعديل البيانات"  formmethod = "POST" formaction="itemsedit.php"/>
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
بحث عن صنف
</div>

    <form  class="searchclass"  method="POST" action="itemssearch.php">
        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white" class="input-group-text" id="basic-addon2">ابحث بااسم الصنف او الكود الخاص به </span>
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