<?php
    include "header.php";

    if($_SESSION["mystatus"]!=0){
        $curday = date('y-m-d');
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $sql = "DELETE FROM store WHERE date_to_store='$curday'";

            if ($conn->query($sql) === TRUE) {
               
                echo '
                <script>

                window.location.href = "storeadd.php";
                </script>

                ';
              echo '<div  id="test" class="alert alert-warning"  role="alert">تم الحذف بنجاح </div>';
        }
        }
      
        echo '<div class="alert alert-warning"  role="alert">
        حذف المخزون اليومي كاملا </div>';


?>
        <form method="POST" action="storedaydelete.php" style="margin:auto;width:1200px;">
        <button type="submit" name="runedit" class="btn btn-outline-danger btn-lg w-100">اضغط للحذف</button>
        </form>

<?php
    }else{
        echo ' <script> window.location.href = "index.php"; </script>';
      }
      include_once "footer.php";
    ?>