<?php
ini_set("display_errors",0);
header("Content-Type: text/html; charset=ISO-8859-1");
include "config.php";

if(isset($_POST['but_import'])){
   $target_dir = "uploads/";
   $target_file = $target_dir . basename($_FILES["importfile"]["name"]);

   $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

   $uploadOk = 1;
   if($imageFileType != "csv" ) {
     $uploadOk = 0;
   }

   if ($uploadOk != 0) {
      if (move_uploaded_file($_FILES["importfile"]["tmp_name"], $target_dir.'importfile.csv')) {

        // Checking file exists or not
        $target_file = $target_dir . 'importfile.csv';
        $fileexists = 0;
        if (file_exists($target_file)) {
           $fileexists = 1;
        }
        if ($fileexists == 1 ) {

           // Reading file
           $file = fopen($target_file,"r");
           $i = 0;

           $importData_arr = array();
                       
           while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
             $num = count($data);

             for ($c=0; $c < $num; $c++) {
                $importData_arr[$i][] = $data[$c];
             }
             $i++;
           }
           fclose($file);

           $skip = 0;
           // insert import data
           foreach($importData_arr as $data){
              if($skip != 0){
                 $username = $data[0];
                 $fname = $data[1];
                 $email = $data[2];
                 //$email = $data[3];

                 // Checking duplicate entry
                 $sql = "select count(*) as allcount from user where username='" . $username . "' and fname='" . $fname . "'  and email='" . $email . "' ";

                 $retrieve_data = mysqli_query($con,$sql);
                 $row = mysqli_fetch_array($retrieve_data);
                 $count = $row['allcount'];

                 if($count == 0){
                    // Insert record
                    $insert_query = "insert into user(username,fname,email) values('".$username."','".$fname."','".$email."')";
                    mysqli_query($con,$insert_query);
                 }
              }
              $skip ++;
           }
           $newtargetfile = $target_file;
           if (file_exists($newtargetfile)) {
              unlink($newtargetfile);
           }
         }

      }
   }
}
?>
<!-- Import form (start) -->
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>


 
<!-- Import form (start) -->
<div class="popup_import">
<body>
<h1>Send Personalized Emails By Uploading CSV </h1>
<div id="main" class="col-sm-12 col-md-6 col-lg-6">
<div id="csv_sec">
<h1>Instructions For Excel Sheet</h1>
<li>Column-1 Should be Name, Column-2 Should be Subject And Column-3 Should be Email</li><p></p>
<li>The Excel Sheet Contains only 200 Numbers Of Email.</li>
<li>Download simple csv file for idea.<a href="import.csv" target="_blank">Download Sample</a></li>
<p><li><b>Please Follow the Above Instructions Then Upload The CSV File.</b></li></p>
 <form method="post" action="" enctype="multipart/form-data" id="import_form">
 
  <table width="100%">
<tr>
   
   </tr>
   <tr>
    <td colspan="2">
    <center>Upload Csv File: <input type='file' name="importfile"  class="csv_upload" id="importfile"></center>
    </td>
   </tr>
   <tr>
    <td colspan="2" ><input type="submit" class="csv_upload" id="but_import" name="but_import" value="Upload"></td>
   </tr>
   
   
   <tr>
   
    <td colspan="2" align="center"></td>
   </tr>
<tr>
   <td colspan="1" ><a href="send/index.php" class="csv_upload" > 
   <br>
   <center><input type="button" class="csv_upload" id="" name="" value=" Go To Message Page"></a></td></center>
   </tr>
   
  
</div>
<!-- Import form (end) -->

<!-- Displaying imported users -->
