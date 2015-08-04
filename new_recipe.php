<?php include('inc/header.php'); 

if(isset($_POST['add_recipe'])){
    //creating new recipe
    $name=addslashes($_POST['name']);
    $directions=addslashes($_POST['directions']);
    $new_recipe="INSERT INTO recipes (name, directions) VALUES ('{$name}', '{directions}')";
    $recipe_added=mysqli_query($connection, $new_recipe);
    if($recipe_added){  
        //For each ingredient, add to recipe_ingredients
        $_SESSION['message']="New Recipe Created!"; 
        redirect_to('recipes.php');
                     
    }else{
     $_SESSION['message']="Could Not Add Recipe"; 
        redirect_to('recipes.php');
    }//end insert recipe
}//end add new recipe

//SHOW recipe SUBMITTED HISTORY
    
    ?>
    <h1 id="center">New Recipe</h1>
    <br>
    <form id="new_recipe" action="#" method="POST">

        <input maxlength="50" type="text" name="name" placeholder="Ingredient Name (i.e. Chiken Tikka Masala)">
        <br>
        <p>Add Ingredients Coming Soon!</p>
        <br>
        Cooking Instructions:
        <textarea name="directions" id="" cols="30" rows="10"></textarea>
        <br>
        <input type="submit" name="add_recipe" value="Submit Recipe">
    </form>
