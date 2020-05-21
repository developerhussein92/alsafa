<?php
        include "header.php";
        if($_SESSION["mystatus"]!=0){    
            if (isset($_GET['del'])) {
                $id = $_GET['findhscode'];
                
                $sql = "DELETE FROM itemssan WHERE id=$id";
            
                if ($conn->query($sql) === TRUE) {
                  echo '<div  id="test" class="alert alert-warning"  role="alert">
                       تم الحذف بنجاح 
                </div>  
                
                 
                ';
                } else {
                   
                }
            
              }

            if($_SERVER['REQUEST_METHOD'] == "GET")
            {
                 $name = $_GET['name'];
                 $san_code = $_GET['code'];
                 $state = 0;
            }
            if($_SERVER['REQUEST_METHOD'] == "POST")
            {
                 $name = $_POST['name'];
                 $san_code = $_POST['san_code'];
                 $items_hscode =$_POST['items_hscode'];
                 $percentage = $_POST['percentage'];
                 $state = 0;
            

            
        $sql = "
        SELECT *
        FROM itemssan
        ";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                    if($items_hscode == $row['items_hscode'] && $san_code == $row['san_code'] )
                    {
                        echo '<div class="alert alert-warning"  role="alert">
                    لقد ادخلت قيمه لهذا الصنف من قبل'.'  <span style="color:red;font-weight:bold">'.$name.'
                     </span></div>';
                    
                        $state = 1;
                    }
                    
                       
                    
                }
                
            }
            if($state == 0 )
            {
                $sql = "INSERT INTO itemssan (items_hscode, san_code,percentage)
                VALUES ('$items_hscode', '$san_code',$percentage)";
                if (mysqli_query($conn, $sql)) {
                    echo ' <script> window.location.href = "sanadditems.php?name='.$name.'&&code='.$san_code.'"; </script>';
                  
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }

        }
?>


<div class="alert alert-danger"  role="alert">
اضافة مكونات للوجبة 
</div>

    <form id="ooop" method="POST" action="sanadditems.php">

        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white" class="input-group-text" id="basic-addon2">Name</span>
            </div>
            <input readonly type="text" value="<?php echo $name;?>"name="name" class="form-control btn-lg w-50" placeholder="ادخل اسم الوجبة" aria-label="Recipient's username" aria-describedby="basic-addon2">
        
        </div>

        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white"  class="input-group-text" id="basic-addon2">CODE</span>
            </div>
            <input readonly type="text" value="<?php echo $san_code;?>" class="form-control btn-lg w-50" name="san_code" placeholder="ادخل كود الوجبة" aria-label="Recipient's username" aria-describedby="basic-addon2">
        
        </div>  
        <hr>    
        <div class="alert alert-primary"  role="alert">
        اضافة الاصناف للوجبات
</div>
         <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white" class="input-group-text" id="basic-addon2">اختر اسم الصنف</span>
            </div>
            <select required style="border:1px solid #ac42b3;min-height:50px" class="form-control btn-lg w-50" name="items_hscode" aria-label="Recipient's username" aria-describedby="basic-addon2">
                <?php
                $sql = "SELECT * FROM items";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $x = 0;
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result)) {

                ?>
                <option name="items_hscode" value ="<?php echo $row['hscode']?>" ><?php echo $row['name']?></option>

                <?php
                    }}
                ?>
                </select>
                <input required style="height:50px" type="text" name="percentage" class="form-control btn-lg w-25" placeholder="ادخل النسبة " aria-label="Recipient's username" aria-describedby="basic-addon2">
        
                </div>  

        
                <input type="hidden" name="name" value = "<?php echo $name;?>"/>
   <input type="hidden" name="code" value = "<?php echo $san_code;?>"/>
       <!-- <button onclick="" type="button" class="btn btn-outline-success btn-lg w-50"  id="addrow">اضافه صنف اخر</button>
       --> <button  style="margin-top:20px;" type="submit" class="btn btn-outline-success btn-lg w-50">حفظ</button>
    </form>
<hr>
    <div class="alert alert-warning"  role="alert">
        المكونات الحالية
        </div>


<table class="table table-hover table-bordered table-striped table-dark">  
<thead style="">
<tr>
  <th>اسم الوجبة</th>
  <th>الصنف</th>
  <th>النسبة</th>
  <th>العمليات</th>
</tr>
<thead>
<tbody>
<?php 

$sql = "
SELECT itemssan.id,itemssan.items_hscode,itemssan.percentage,items.name AS realname,items.hscode
FROM itemssan
INNER JOIN items ON itemssan.items_hscode = items.hscode
WHERE san_code =  $san_code
";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
?>
<tr>
<td><?php echo $name."  "; ?></td>
<td><?php echo $row["realname"]."    " ; ?></td>
<td><?php echo $row["percentage"]."  "; ?></td>
<td  style="text-align:center">
    
   <form action="sanadditems.php" method="GET"> 
   <input type="hidden" name="name" value = "<?php echo $name;?>"/>
   <input type="hidden" name="realname" value = "<?php echo $row['realname'];?>"/>
   <input type="hidden" name="code" value = "<?php echo $san_code;?>"/>
    <input style="margin-left:20px" class="btn btn-danger" name="del" type="submit" value="حذف العنصر" />
    <input type="hidden" name= "findhscode" value="<?php echo $row["id"]?>"/>
    <input class="btn btn-secondary" type="submit" name="edit" value="تعديل البيانات"  formmethod = "POST" formaction="sanitemsedit.php"/>
  </form>
   
</td>
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
</table>














<?php         
        }else{
            echo ' <script> window.location.href = "index.php"; </script>';
          }
      include_once "footer.php";
?>