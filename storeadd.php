<?php 
    include "header.php";
    if($_SESSION["mystatus"]!=0){
    $month = date('n'); 
    $curday = date('y-m-d');
?>
<?php
    // find data to show in first
    $sql2 = 
    "
        SELECT * FROM items
    ";
    $result2 = mysqli_query($conn, $sql2);
       if (mysqli_num_rows($result2) > 0) {
        // output data of each row
        while($row2 = mysqli_fetch_assoc($result2)) {
            $pp =  $row2['hscode'];
            $sql3 = "
            SELECT items.name,items.hscode,store.pre_account,store.income_id,store.sales,store.kitchen,store.other_account,store.notes,store.date_to_store
            FROM store
            INNER JOIN items ON store.items_hscode = items.hscode
            WHERE items.hscode = '$pp'
            ORDER BY store.date_to_store DESC
            limit 1
                ";
                $result3 = mysqli_query($conn, $sql3);
                if (mysqli_num_rows($result3) > 0) {
                    // output data of each row
                    while($row3 = mysqli_fetch_assoc($result3)) {
                        $arr[$row3['hscode']] = Array('other'=>$row3['other_account']);
        }
        } else {
      
        }

            }
       }
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        for($x=0;$x<count( $_POST['items']);$x++)
        {
                $items_hscode = $_POST['items'][$x];
                $pre_account = $_POST['pre_account'][$x];
                $income_id = $_POST['income'][$x];
                if($income_id == null)
                {
                    $income_id = "null";
                   
                }else
                {
                    $income_id = "'".$_POST['income'][$x]."'"; 
                }
                $income_value = $_POST['income_value'][$x];
                $sales = $_POST['sales'][$x];
                $kitchen = $_POST['kitchen'][$x];
                @$other_account = ($pre_account+$income_value)-($sales+$kitchen);
                $notes = $_POST['notes'][$x];
                $date = date("Y-m-d H:i:s");

            $sql = "
            INSERT INTO store (items_hscode, pre_account,income_id,sales,kitchen,other_account,notes,date_to_store)
                        VALUES (
                            '$items_hscode',
                            '$pre_account',
                             $income_id,
                            '$sales',
                            '$kitchen',
                            '$other_account',
                            '$notes',
                            '$date'
                            )";

                            $sql2 = "
                            SELECT *
                            FROM store
                            WHERE items_hscode = '$items_hscode' AND date(store.date_to_store) = '$curday';
                                ";
                            $result2 = mysqli_query($conn, $sql2);
                            if (mysqli_num_rows($result2) > 0) {
                                // output data of each row
                                while($row2 = mysqli_fetch_assoc($result2)) {
                                        
                                }}else
                                {
                                    if (mysqli_query($conn, $sql)) {
                                        echo '<script>window.location.href = "storeshowday.php"; </script>';
                                       } else {
                                     echo "error store";
                                       }
                                                                    }          
            }   
    }else
    {          
    }
?>
<form action="storeadd.php" method="POST">
    <div class="alert alert-danger"  role="alert">
    اضافة للمخزون اليومي
     <?php 
        $d = date('d');
        $m = $armonth[$month-1];
        $y = date('Y');
        echo $d." - ".$m." - ".$y;
    ?>   
    </div>
<form>
<table class="table table-hover table-bordered table-striped table-dark">
<thead>
    <tr>
        <th>HSCODE</th>
        <th>اسم الصنف</th>
        <th>رصيد اول المدة </th>
        <th>وارد</th>
        <th>مبيعات</th>
        <th>محول للمطبخ</th>
        <th>رصيد أخر</th>
        <th>ملاحظات</th>  
    </tr>
</thead>
</tbody>
<?php 
    include "conn.php";
    $sql = "SELECT * FROM items";
    $result = mysqli_query($conn, $sql);
    $x=0;
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $hscode = $row['hscode']; 
            $items_hscode = $hscode;
            $sql2 = "SELECT * FROM income WHERE items_hscode=$hscode  AND date_to_income ='$curday' ";
            $result2 = mysqli_query($conn, $sql2);
           
            if (mysqli_num_rows($result2) > 0) {
                // output data of each row
                while($row2 = mysqli_fetch_assoc($result2)) {
                     $income_id = $row2['id'];
                    $income_value = $row2['account'];
                }
            } else{ echo $income_id = null;
                $income_value = 0 ; }       
/*************************************************************************************************************************** */ // ADD KITCHEN VALUE
$allnumber = 0;
$usedunit = 0;
$mykitchen = 0;
/////////////////
  $sql55 = "
  SELECT items.name,items.dest,itemssales.san_code,itemssales.number AS allnumber,itemssales.items_hscode,itemssales.number,itemssales.date_to_store
  FROM itemssales
  INNER JOIN  items ON items.hscode = itemssales.items_hscode 
  WHERE itemssales.items_hscode = '$items_hscode'  AND  date(date_to_store) = '$curday'; 
  ";
  $result55 = mysqli_query($conn, $sql55);
  if (mysqli_num_rows($result55) > 0) {
  
    // output data of each row
    while($row55 = mysqli_fetch_assoc($result55)) {
      $name =  $row55['name'];
      $san_code = $row55['san_code'];
      $allnumber += $row55['allnumber'];
      $alone = $row55['allnumber'];
      $dest = $row55['dest'];
      $sql22 = "
  SELECT percentage
  FROM itemssan
  WHERE items_hscode = '$items_hscode' AND san_code = '$san_code'

  ";
  $result22 = mysqli_query($conn, $sql22);
  if (mysqli_num_rows($result22) > 0) {
    // output data of each row
    while($row22 = mysqli_fetch_assoc($result22)) {
       $percentage = $row22['percentage'];
       // echo "hscode: ".$items_hscode."  sancode : ".$san_code." percentage: ".$percentage."<br/>";
        $usedunit +=$alone*$percentage;  
    }}
    $mykitchen = $usedunit+($usedunit*$dest);
  }

    } 


        
////////////////////


/*************************************************************************************************************************** */
?>
<tr>
<input type="hidden" name="items[]" value="<?php echo $row["hscode"] ?> " />
<td style="width:60px;padding:10px 10px;font-weight:bold;font-size:1.2em;width:150px "><?php echo $row["hscode"]; ?></td>
<td style="width:70px;padding:10px 10px;font-weight:bold;font-size:1.2em;width:150px "><?php echo $row["name"]; ?></td>
<td><input style="width:70px;padding:10px 10px;font-weight:bold;font-size:1.2em" type="text" name="pre_account[]" value="<?php  
if(isset($arr)){
    if(array_key_exists($row['hscode'],$arr)){
        echo $arr[$row['hscode']]['other'];
    }else{
        echo "0";
    }
}
?>"   id="<?php echo "pre_account$x"; ?>"/></td>

<input type="hidden" name="income[]"  id="<?php echo "income$x"; ?>"
value="<?php if(isset($income_id)){echo $income_id;} ?>">

<td>
<input readonly style="width:90px;padding:10px 10px;font-weight:bold;font-size:1.2em" name = "income_value[]" type="text"   id="<?php echo "income$x"; ?>"
value="<?php if(isset($income_value)){echo $income_value;} ?>">
</td>
<td><input style="width:90px;padding:10px 10px;font-weight:bold;font-size:1.2em" type="text" name="sales[]"  id="<?php echo "sales$x"; ?>" /></td>
<td><input style="width:90px;padding:10px 10px;font-weight:bold;font-size:1.2em" type="text" name="kitchen[]" id="<?php echo "kitchen$x"; ?>" value= "<?php echo $mykitchen;?>"/></td>
<td><input style="width:90px;padding:10px 10px;font-weight:bold;font-size:1.2em" type="text"  name="other_account[]" id="<?php echo "other_account$x"; ?>"/></td>
<td><textarea cols="15" rows="1" style="padding:10px 10px;font-weight:bold;font-size:1.2em"  name="notes[]">   </textarea></td>

</tr>   

<?php

 $x++;
        }
        } else {
        echo "0 results";
        }
?>
 </table>
 <button class="btn btn-primary w-25 lop">أضافة المخزون اليومي</button>
 </form>
 































 <script>
    <?php 
        for($o=0;$o<$x;$o++){
            
    ?>

    var
     pre<?php echo $o;?>     = document.getElementById('pre_account<?php echo $o;?>'),
     income<?php echo $o;?>  = document.getElementById('income<?php echo $o;?>'),
     sales<?php echo $o;?>   = document.getElementById('sales<?php echo $o;?>'),
     kitchen<?php echo $o;?> = document.getElementById('kitchen<?php echo $o;?>'),
     other<?php echo $o;?>   = document.getElementById('other_account<?php echo $o;?>');

   

     pre<?php echo $o;?>.onkeyup = function(){
        var preval<?php echo $o;?>     = parseInt(pre<?php echo $o;?>.value);
        var incomeval<?php echo $o;?>  = parseInt(income<?php echo $o;?>.value);
        var salesval<?php echo $o;?>   = parseInt(sales<?php echo $o;?>.value);
        var kitchenval<?php echo $o;?> = parseInt(kitchen<?php echo $o;?>.value);
       
         
        other<?php echo $o;?>.value = (preval<?php echo $o;?>+incomeval<?php echo $o;?>)-(salesval<?php echo $o;?>+kitchenval<?php echo $o;?>);
        
     };
     income<?php echo $o;?>.onkeyup = function(){
        var preval<?php echo $o;?>     = parseInt(pre<?php echo $o;?>.value);
        var incomeval<?php echo $o;?>  = parseInt(income<?php echo $o;?>.value);
        var salesval<?php echo $o;?>   = parseInt(sales<?php echo $o;?>.value);
        var kitchenval<?php echo $o;?> = parseInt(kitchen<?php echo $o;?>.value);
       
         
        other<?php echo $o;?>.value = (preval<?php echo $o;?>+incomeval<?php echo $o;?>)-(salesval<?php echo $o;?>+kitchenval<?php echo $o;?>);
        
     };
      sales<?php echo $o;?>.onkeyup = function(){
        var preval<?php echo $o;?> = parseInt(pre<?php echo $o;?>.value);
         var incomeval<?php echo $o;?> = parseInt(income<?php echo $o;?>.value);
         var salesval<?php echo $o;?> = parseInt(sales<?php echo $o;?>.value);
         var kitchenval<?php echo $o;?> = parseInt(kitchen<?php echo $o;?>.value);
         var otherval<?php echo $o;?> = parseInt(other<?php echo $o;?>.value);
        
         other<?php echo $o;?>.value = (preval<?php echo $o;?>+incomeval<?php echo $o;?>)-(salesval<?php echo $o;?>+kitchenval<?php echo $o;?>);
      };
      kitchen<?php echo $o;?>.onkeyup = function(){
         var preval<?php echo $o;?> = parseInt(pre<?php echo $o;?>.value);
         var incomeval<?php echo $o;?> = parseInt(income<?php echo $o;?>.value);
         var salesval<?php echo $o;?> = parseInt(sales<?php echo $o;?>.value);
         var kitchenval<?php echo $o;?> = parseInt(kitchen<?php echo $o;?>.value);
         var otherval<?php echo $o;?> = parseInt(other<?php echo $o;?>.value);
        
         other<?php echo $o;?>.value = (preval<?php echo $o;?>+incomeval<?php echo $o;?>)-(salesval<?php echo $o;?>+kitchenval<?php echo $o;?>);
      };
    
    

    <?php

        }
    ?>
 </script>
<?php 
}else{
    echo ' <script> window.location.href = "index.php"; </script>';
  }
    include "footer.php";
?>