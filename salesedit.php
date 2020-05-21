<?php
        include "header.php";
        if($_SESSION["mystatus"]!=0){
            $curday = date('y-m-d');
        if (isset($_POST['runedit']))
        {
                $id = $_POST['id'];
                $number =$_POST['number'];
              
              
            $sql = 
            "
            UPDATE sales
            SET number = '$number' WHERE id = '$id';
            "
            ;
            if ($conn->query($sql) === TRUE) {
                $sql = 
            "
            UPDATE itemssales
            SET number = '$number' WHERE sales_id = '$id';
            "
            ;
            if ($conn->query($sql) === TRUE) {
                  /*************************************************************************************************************************** */ // ADD KITCHEN VALUE
                  $sql2 = "SELECT * FROM items";
                  $result2 = mysqli_query($conn, $sql2);
                  if (mysqli_num_rows($result2) > 0) {
                      // output data of each row
                      while($row2 = mysqli_fetch_assoc($result2)) {

                           $items_hscode = $row2['hscode'];
                      $sql3 = "
                      SELECT items.name,items.dest,itemssales.san_code,SUM(itemssales.number) AS allnumber,itemssales.items_hscode,itemssales.number,itemssales.date_to_store
                      FROM itemssales
                      INNER JOIN  items ON items.hscode = itemssales.items_hscode 
                      WHERE date(itemssales.date_to_store) = '$curday' AND items_hscode = '$items_hscode'
                      ";
                      $result3 = mysqli_query($conn, $sql3);
                      if (mysqli_num_rows($result3) > 0) {
                      // output data of each row
                      while($row3 = mysqli_fetch_assoc($result3)) {
                          $items_hscode = $row3['items_hscode'];
                          $san_code = $row3['san_code'];
                          $sql4 = "
                      SELECT percentage
                      FROM itemssan
                      WHERE items_hscode = '$items_hscode' AND san_code = '$san_code'
      
                      ";
                      $result4 = mysqli_query($conn, $sql4);
                      if (mysqli_num_rows($result4) > 0) {
                      // output data of each row
                      while($row4 = mysqli_fetch_assoc($result4)) {
                          $percentage = $row4['percentage'];
                      }}
                      $mykitchen = ( $row3['allnumber']*$percentage*$row3['dest'])+($row3['allnumber']*$percentage);
                      }}
                      /**********SELECT FROM STORE */
                      $sql5 = "
                      SELECT *
                      FROM store
                      WHERE items_hscode = '$items_hscode' AND date_to_store = '$curday'
                      ";
                      $result5 = mysqli_query($conn, $sql5);
                      if (mysqli_num_rows($result5) > 0) {
                        
                      // output data of each row
                      while($row5 = mysqli_fetch_assoc($result5)) {

                          $income_id = $row5['income_id'];
                          if($income_id =="")
      
                          {
                               $income_value = 0;
                          }else{
                              $sql77 = "SELECT account FROM income WHERE id = $income_id;";
                              $result77 = mysqli_query($conn, $sql77);
                              if (mysqli_num_rows($result77) > 0) {
                              // output data of each row
                              while($row77 = mysqli_fetch_assoc($result77)) {
                                  $income_value = $row77['account'];
                              }}
                          }
                          $pre = $row5['pre_account'];
                          $sales = $row5['sales'];
                          @$other = ($pre+$income_value)-($sales+$mykitchen);
                          $store_id = $row5['id'];


                        
      
      
                          /***************UPDATE STORE */
                          $sql22 = 
                            "
                            UPDATE store
                            SET 
                            pre_account = '$pre', 
                            sales= '$sales',
                            kitchen= '$mykitchen',
                            other_account= '$other'
                            WHERE id = '$store_id';
                            "
                            ;
                
                            if ($conn->query($sql22) === TRUE) {}else{}

                      }}
                    
                    
                      /**********END SELECT FROM STORE */
      
              
   /***************END UPDATE STORE */
      
                  }}
                echo '<script> window.location.href = "salesprocess.php";</script>';
            }
            
                
            } else {
              
            }

                   
         /*************************************************************************************************************************** */
         

        }

    if (isset($_POST['findhscode']))
    {
       
        $id = $_POST['findhscode'];
        $name = $_POST['name'];
        
        $sql = "
        SELECT *
         FROM sales
         WHERE id  = '$id'
        ";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {

?>


<div class="alert alert-danger"  role="alert">
تعديل مبيعات الوجبات 

</div>

    <form method="POST" action="salesedit.php">
    <input type="hidden" name="id" value="<?php echo $row['id'];?>"/>

    <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white" class="input-group-text" id="basic-addon2">اسم الوجبة</span>
            </div>
            <input readonly type="text" value="<?php echo $name?>" class="form-control btn-lg w-50"  aria-label="Recipient's username" aria-describedby="basic-addon2">
        
        </div>

        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white" class="input-group-text" id="basic-addon2">الكود</span>
            </div>
            <input readonly type="text" value="<?php echo $row['san_code']?>" class="form-control btn-lg w-50"  aria-label="Recipient's username" aria-describedby="basic-addon2">
        
        </div>

        
        <div class="input-group mb-3 btn-lg w-50">
            <div class="input-group-append">
                <span style="background-color:black;color:white" class="input-group-text" id="basic-addon2">عدد الوجبات</span>
            </div>
            <input type="text" name="number" value="<?php echo $row['number']?>" class="form-control btn-lg w-50" placeholder="ادخل اسم المورد" aria-label="Recipient's username" aria-describedby="basic-addon2">
        
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