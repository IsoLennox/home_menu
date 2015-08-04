<?php include('inc/header.php');   
 

    $date=addslashes(date('m/d/Y h:i'));
    $recipe_id=$_POST['recipe_id'];
    //FIND UPLOADS FOLDER
    $target_dir = ".multi-file-upload/uploads/";
    $unique=date('mdYhis');
   
    
    for($i=0; $i<count($_FILES['image']['name']); $i++) {
        
        
$target_file = $target_dir  . $unique . basename($_FILES["image"]["name"][$i]); 
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      
        
    } else {  
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
   // echo "Sorry, FILE NAME already exists.";
    echo "Sorry, FILE NAME already exists.".$target_file."<br/>"; 
    $uploadOk = 0;
}
// Check file size
//if ($_FILES["image"]["size"] > 5000000) {
//    //echo "Sorry, your file is too large.";
//    echo "Sorry, your file is too large. 5000kb is the max file size."; 
//    $uploadOk = 0;
//}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "docx" && $imageFileType != "DOCX" && $imageFileType != "pdf" && $imageFileType != "PDF" && $imageFileType != "xls" && $imageFileType != "txt" && $imageFileType != "psd"  && $imageFileType != "html"  && $imageFileType != "php"  && $imageFileType != "ppt"  && $imageFileType != "css" ) { 
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed."; 
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
   
   
     $_SESSION["message"] = "Your file was not uploaded."; 
            redirect_to("recipes.php?id=".$recipe_id);
// if everything is ok, try to upload file
} else {
    
//    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
//   rename($_FILES["image"]["tmp_name"], $target_file); 
    
    if (move_uploaded_file($_FILES["image"]["tmp_name"][$i], $target_file)) {
        //FILE UPLOADED! 
//        echo "success! Inserted into DB<br/>";  
         $insert_file = "INSERT INTO recipe_files (filepath, datetime, recipe_id, uploaded_by) VALUES ('hi', 'hi', 3, 3)";
        $file_result = mysqli_query($connection, $insert_file);
       
     
    } else {
        echo "Sorry, there was an error uploading your file: ".$_FILES["image"]["tmp_name"]." -> ".$target_file; 
        $_SESSION["message"] = "There was an error";
            redirect_to("recipes.php?id=".$recipe_id);
    }
    }

}
           if ($file_result) {
         $_SESSION["message"] = "Attachment Saved!";
            redirect_to("recipes.php?id=".$recipe_id);
        }else{
              $_SESSION["message"] = "recipe Saved: Link not created.";
            redirect_to("recipes.php?id=".$recipe_id);
        }
         

 
?>  