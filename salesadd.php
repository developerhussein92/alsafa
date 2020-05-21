<?php 
    include "header.php";
    if($_SESSION["mystatus"]!=0){
    $month = date('n'); 
    $curday = date('y-m-d');
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        for($x=0;$x<count( $_POST['items']);$x++)
        {          
                $san_code = $_POST['san_code'][$x];
                $number = $_POST['number'][$x];
                $date_to_sales = date('y-m-d h:m:s');
            $sql = "
            INSERT INTO sales (san_code,number,date_to_sales)
                        VALUES (
                            '$san_code',
                            '$number',
                            '$date_to_sales'
                            )";

                            if( $number  != 0 )
                            {
                                if (mysqli_query($conn, $sql)) {
                                    /////////////
                                     $sales_id = $conn->insert_id;

                                    $sql2 = "
                                        SELECT *
                                        FROM itemssan
                                        WHERE san_code =  $san_code
                                        ";
                                        $result2 = mysqli_query($conn, $sql2);
                                        if (mysqli_num_rows($result2) > 0) {
                                        // output data of each row
                                        while($row2 = mysqli_fetch_assoc($result2)) {
                                            $items_hscode = $row2['items_hscode'];
                                            $sql3 = "
                                            INSERT INTO itemssales (san_code,items_hscode,sales_id,number,date_to_store)
                                                        VALUES (
                                                            '$san_code',
                                                            '$items_hscode',
                                                            '$sales_id',
                                                            '$number',
                                                            '$date_to_sales'
                                                            )";
                                                            if (mysqli_query($conn, $sql3)) { }
                                        }
                                        }

                                    ///////////////

                                    echo ' <script> window.location.href = "salessanshow.php"; </script>';
                                   } else {
                                 echo "error store";
                                   }
                            }
            }   
    }else
    {
               
    }
?>

<form action="salesadd.php" method="POST">
  

    <div class="alert alert-danger"  role="alert">
    اضافة مبيعات يوم
     <?php 
        $d = date('d');
        $m = $armonth[$month-1];
        $y = date('Y');
        echo $d." - ".$m." - ".$y;
    
    ?>    </div>


<table class="table table-hover table-bordered table-striped table-dark">
<thead>
    <tr>
        <th>كود الوجبة</th>
        <th>اسم الوجبة</th>
        <th>عدد الوجبات المباعه </th>
        
    </tr>
</thead>
</tbody>
<?php 
    include "conn.php";
    $sql = "SELECT * FROM san";
    $result = mysqli_query($conn, $sql);
    $x=0;
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {?>
            <tr>
            <input type="hidden" name="items[]" value="<?php echo $row["code"] ?> " />
            <input type="hidden" name="san_code[]" value="<?php echo $row["code"] ?> " />
            <td style="padding:10px 10px;font-weight:bold;font-size:1.2em;"><?php echo $row["code"]; ?></td>
            <td style="padding:10px 10px;font-weight:bold;font-size:1.2em"><?php echo $row["name"]; ?></td>
            <td><input name="number[]" style="padding:10px 10px;font-weight:bold;font-size:1.2em" type="text" /></td>
            
            </tr>
        <?php
        }
     }else {
        echo "0 results";
        }

?>
 </table>
 <button style="margin-right:250px" class="btn btn-primary w-50 lop">اضافة مبيعات اليوم</button>
 </form>
 

<?php 

}else{
    echo ' <script> window.location.href = "index.php"; </script>';
  }
    include "footer.php";
?>