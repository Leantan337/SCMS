<?php

include'../includes/connection.php';
?>
          <!-- Page Content -->
          <div class="col-lg-12">
            <?php
              $name = $_POST['companyname'];
              $tin_num = $_POST['tin_num'];
              $ID_num = $_POST['ID_num'];
              $prov = $_POST['province'];
              $cit = $_POST['city'];
              $phone = $_POST['phonenumber'];
        
              switch($_GET['action']){
                case 'add':     
                    $query = "INSERT INTO location
                              (LOCATION_ID, PROVINCE, CITY)
                              VALUES (Null,'{$prov}','{$cit}')";
                    mysqli_query($db,$query)or die ('Error in updating location in Database');

                    $query2 = "INSERT INTO supplier
                              (SUPPLIER_ID, COMPANY_NAME,tin_num,ID_num, LOCATION_ID, PHONE_NUMBER)
                              VALUES (Null,'{$name}','{$tin_num}','{$ID_num}',(SELECT MAX(LOCATION_ID) FROM location),'".$phone."')";
                    mysqli_query($db,$query2)or die ('Error in updating supplier in Database');
                break;
              }
            ?>
              <script type="text/javascript">window.location = "supplier.php";</script>
          </div>

<?php
include'../includes/footer.php';
?>