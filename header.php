<?php

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

      include_once "conn.php";
    $armonth = Array('يناير','فبراير','مارس','ابريل','مايو','يونية','يوليو','اغسطس','سبتمبر','اكتوبر','نوفمبر','ديسمبر');
    
?>
<!doctype html>
<html lang="ar" dir="rtl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/rtl/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <title>شركة الصفا لبيع وتجهيز الاسماك</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">

    <li class="nav-item dropdown" >
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo  $_SESSION["username"];?>
        </a>
     
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
         
            <?php   
            $state = $_SESSION["mystatus"];
            if($state == 3)
            {?>
              <a class="dropdown-item" href="usersaccount.php"> ادارة جميع المستخدمين</a>
              <div class="dropdown-divider"></div>
              <?php
            }else if($state == 0){
            
            }
            ?>
          
          
          <a class="dropdown-item" href="reset-password.php"> تغيير كلمة السر</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php">تسجيل الخروج</a>

         
        </div>
      </li>
      
      <li class="nav-item dropdown" >
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          الاصناف
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="itemsadd.php"> اضافة صنف جديد</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="itemsshow.php">عرض الاصناف</a>
          <div class="dropdown-divider"></div>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="itemsprocess.php">تعديل او حذف صنف</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="itemssearch.php">بحث عن صنف</a>
        </div>
      </li>

      <li class="nav-item dropdown" >
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          قائمة الموردين
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="supplieradd.php"> اضافة مورد جديد</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="suppliershow.php">عرض الموردين</a>
          <div class="dropdown-divider"></div>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="supplierprocess.php">تعديل او حذف مورد</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="suppliersearch.php">بحث عن مورد</a>
        </div>
      </li>

      <li class="nav-item dropdown" >
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          المخزون
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="storeadd.php">اضافة المخزون اليومي</a>
         
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="storeshowday.php">عرض المخزون اليومي</a>
          <a class="dropdown-item" href="storeshowdayprocess.php">تعديل أو حذف المخزون اليومي</a>
          <a class="dropdown-item" href="storedaydelete.php">حذف المخذون اليومي كاملا</a>
          
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="storeshowmonth.php">عرض المخزون الشهري تفصيليا</a>
          <a class="dropdown-item" href="storeshowmonthall.php">عرض المخزون الشهري أجماليا</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="storeshowyear.php">عرض المخزون السنوي تفصيليا</a>
          <a class="dropdown-item" href="storeshowyearall.php">عرض المخزون السنوي اجماليا</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="storesearch.php">بحث في المخزون</a>
        </div>
      </li>

      <li class="nav-item dropdown" >
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          قائمة الاسعار 
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="incomeadd.php">اضافة لقائمة الاسعار</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="incomeshowday.php"> عرض قائمة الاسعار اليومية تفصيليا </a>
          <a class="dropdown-item" href="incomeshowdayprocess.php">تعديل أو حذف قائمة الاسعار اليومية</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="incomeshowmonth.php">عرض قائمة الاسعار الشهرية تفصيليا</a>
          <a class="dropdown-item" href="incomeshowmonthday.php">عرض قائمة الاسعار الشهرية بالايام</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="incomeshowyear.php">عرض قائمة الاسعار السنوية تفصيليا</a>
          <a class="dropdown-item" href="incomeshowyearmonth.php">عرض قائمة الاسعار السنوية شهريا</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="incomesearch.php">بحث في قائمة الاسعار</a>
          <a class="dropdown-item" href="incomereportsearch.php">بحث برقم الفاتورة</a>
        </div>
      </li>
      
      <li class="nav-item dropdown" >
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          الوجبات والمطبخ
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="sanadd.php">اضافة وجبه جديد</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="sanprocess.php">تعديل او حذف الوجبات فقط</a>
          <a class="dropdown-item" href="sanitemsshow.php">عرض الوجبات بالاصناف</a>
          <div class="dropdown-divider"></div>

          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="sanshow.php"> اضافه المكونات للوجبات والتعديل علي المكونات</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="sansearch.php">بحث عن وجبه</a>
        </div>
      </li>

      <li class="nav-item dropdown" >
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          المبيعات
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="salesadd.php">اضافة مبيعات اليوم</a>
          <a class="dropdown-item" href="salesprocess.php">تعديل او حذف مبيعات اليوم</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="salessanshow.php"> عرض مبيعات اليوم للوجبات فقط</a>
          <a class="dropdown-item" href="salessanitemsshow.php">عرض مبيعات اليوم للوجبات بالاصناف تفصيليا</a>
          <a class="dropdown-item" href="salessanitemsshowall.php">عرض مبيعات اليوم للوجبات بالاصناف اجماليا</a>
          <div class="dropdown-divider"></div>
         
        </div>
      </li>


    </ul>
    
  </div>
</div>
</nav>

<div class="container site">

