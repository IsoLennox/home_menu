<?php include('inc/header.php'); ?>


    <?php

if(isset($_POST['recipes'])){ 
    $query=$_POST['query'];  
                 //Searching within a recipe 
                             
            $recipe_query = "SELECT * FROM recipes WHERE name LIKE '%{$query}%' "; 
    //also search for recipe ingredients
    //also search for ingredients
            $recipe_result = mysqli_query($connection, $recipe_query); 
            if ($recipe_result) {  
                echo "<h4>Searching for <em>'".$query."'</em></h4><br/>";
                foreach($recipe_result as $recipe){  
                        echo "<p>".$recipe['name']."</p>"; 
                }//end foreach
            }else{ 
                echo "<h3>No results for <em>'".$query."'</em></h3>";
            }             
}  
include('inc/footer.php'); ?>
