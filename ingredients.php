<?php include('inc/header.php'); 

if(isset($_POST['add_ingredient'])){
     $name=addslashes($_POST['name']);
     $food_type=addslashes($_POST['food_type']);
    
    //Check to see if this ingredient exists
    $get_ingredients="SELECT * FROM ingredients WHERE name='{$name}'";
    $ingredients_found=mysqli_query($connection, $get_ingredients);
    $num_ingredients_found=mysqli_num_rows($ingredients_found);
    if($num_ingredients_found>=1){
     $_SESSION['message']="You Already Have ".$name."!"; 
        redirect_to('ingredients.php');
    }else{ 
    //creating new recipe
    $new_recipe="INSERT INTO ingredients (name, food_type_id) VALUES ('{$name}', {$food_type})";
    $recipe_added=mysqli_query($connection, $new_recipe);
    if($recipe_added){  
        $_SESSION['message']="New Ingredient Created!"; 
        redirect_to('ingredients.php');
                     
    }else{
     $_SESSION['message']="Could Not Add Ingredient"; 
        redirect_to('ingredients.php');
    }//end insert recipe
}//end add new recipe
}//end check to see if ingredient exists

 

//SHOW recipe SUBMITTED HISTORY
    if(isset($_GET['new'])){
    ?>
    <h1 id="center">New Ingredient</h1>
    <br>
    <form id="new_recipe" action="#" method="POST">

        <input maxlength="50" type="text" name="name" placeholder="New Ingredient Name (i.e. Avacado)">
        <br>
        <select name="food_type" id="">
            <?php 
        $get_types="SELECT * FROM food_types ORDER BY name";
        $types_found=mysqli_query($connection, $get_types);
        foreach($types_found as $type){
            echo "<option value=\"".$type['id']."\">".$type['name']."</option>";
        }
        ?>
        </select>
        <br>
        <input type="submit" name="add_ingredient" value="Submit Ingredient">
    </form>
    <?php
    }else{
        echo "<h1>Ingredients</h1>";
        echo "<a href=\"ingredients.php?new\">+ New Ingredient</a>";
        echo "<br/><Br/>";
        //Filter Food Types
          $get_types="SELECT * FROM food_types ORDER BY name";
        $types_found=mysqli_query($connection, $get_types);
        echo "<ul class=\"inline\">";
        foreach($types_found as $type){
            echo "<li>".$type['name']."</li>";
        }
        echo "</ul>";
        
        
        
        echo "<ul id=\"list\">";
        $get_ingredients="SELECT * FROM ingredients ORDER BY name";
        $ingredients_found=mysqli_query($connection, $get_ingredients);
        foreach($ingredients_found as $ingredient){
            $food_type_found=food_type_by_id($ingredient['food_type_id']);
            echo "<li>".$ingredient['name']." (".$food_type_found['name'].") <a href=\"ingredients.php?remove=".$ingredient['id']."\"><i class=\"fa fa-trash-o red right\"></i></a></li>";
        }
        echo "</ul>";
    
    }
?>