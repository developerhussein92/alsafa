<?php
include "header.php";
if (isset($_GET['del'])) {
   
    $id = $_GET['findhscode'];
    
    $sql = "DELETE FROM users WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
      echo '<div  id="test" class="alert alert-warning"  role="alert">
           تم الحذف بنجاح 
    </div>  
    ';
    } else {
    }
  }
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    for($pp = 0;$pp<count($_POST['items']);$pp++)
    {
        $state = $_POST["priv".$pp];
     // echo "STATE ".$state;
         $id = $_POST["id"."$pp"];
      //  echo " ID ".$id."<br/>";
        $sql = "
        UPDATE  users
        SET status = '$state'
        WHERE id = '$id'
         ";
         if (mysqli_query($conn, $sql)) {}
    }
    echo '  <div class="alert alert-success"  role="alert">
           تم تغيير الصلاحيات للمستخدمين
            </div>';
}
if($_SESSION["mystatus"]==3){
?>
<div class="alert alert-danger"  role="alert">ادارة جميع المستخدمين  </div>
<form method="POST" action="usersaccount.php">
<table class="table table-hover table-bordered table-striped table-dark">  
<thead style="">
    <tr>
        <th>اسم المستخدم</th>
        <th>صلاحيات الحاليه</th>
        <th>تغيير الصلاحيات</th> 
        <th>العمليات</th>
    </tr>
</thead>
<tbody>
<?php 
    
    $sql = "
    SELECT id,username,status  FROM users 
    WHERE status <> 3
        ";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $x=0;
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $state = $row['status'];       
?>
<tr>
            <td style="width:100px"><?php echo $row['username']; ?></td>
            <td style="width:100px"><?php
            if($state ==0)
            {
                echo  "هذا المستخدم غير مفعل ولا يستطيع الدخول علي اي صفحة";
            } 
            else  if($state ==1)
            {
                echo "  هذا المستخدم مفعل للدخول علي جميع الصفحات عدا الوارد";
            }
            else  if($state ==2)
            {
                echo " هذا المستخدم مفعل للدخول علي جميع الصفحات  ";
            }
             ?></td>
            <td style="width:100px">
               الغاء التنشيط <input type="radio" name="priv<?php echo $x;?>" value="0" <?php  if($state==0){echo "checked";}?>/><br/>
               
               التنشيط للدخول لجميع الصفحات عدا الوارد <input type="radio" value="1" name="priv<?php echo $x;?>" <?php  if($state==1){echo "checked";}?>/><br/>
               
               التنشيط للدخول لجميع الصفحات <input type="radio" value="2" name="priv<?php echo $x;?>" <?php  if($state==2){echo "checked";}?>/><br/>
            </td>
            <td style="width:100px"><input style="margin-left:20px" class="btn btn-danger" name="del" type="submit" formmethod="GET"  value="حذف العضو نهائيا" /></td>
            <input type="hidden" name="id<?php echo $x;?>"value="<?php echo $row['id']?>" />
            <input type="hidden" name="items[]"/>
            <input type="hidden" name="findhscode" value="<?php echo $row['id']?>" />
</tr>   
<?php
 $x++;
        }

        } else {
       
        }

?>

 </table>
 
 <button class="btn btn-primary w-25 lop">حفظ</button>
        
 </form>

<?php 
}else{
    echo ' <script> window.location.href = "index.php"; </script>';
}
include "footer.php";