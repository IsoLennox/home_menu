<?php include('inc/header.php'); 

if(isset($_POST['add_recipe'])){    
     $name=addslashes($_POST['name']); 
    
    //Check to see if this recipe exists
    $get_recipes="SELECT * FROM recipes WHERE name='{$name}'";
    $recipes_found=mysqli_query($connection, $get_recipes);
    $num_recipes_found=mysqli_num_rows($recipes_found);
    if($num_recipes_found>=1){
     $_SESSION['message']="You Already Have ".$name."!"; 
        redirect_to('index.php');
    }else{ 
    //creating new recipe
    $new_recipe="INSERT INTO recipes (name) VALUES ('{$name}')";
    $recipe_added=mysqli_query($connection, $new_recipe);
    if($recipe_added){  
        $_SESSION['message']="New recipe Created!"; 
        redirect_to('index.php');
                     
    }else{
     $_SESSION['message']="Could Not Add recipe"; 
        redirect_to('index.php');
    }//end insert recipe
}//end add new recipe
}//end check to see if recipe exists




if(isset($_POST['edit_recipe'])){    
     $id=addslashes($_POST['id']); 
     $name=addslashes($_POST['name']); 
     $directions=addslashes($_POST['directions']); 
    
 
    //creating new recipe
    $new_recipe="UPDATE recipes set name='{$name}', directions='{$directions}' WHERE id = {$id}";
    $recipe_added=mysqli_query($connection, $new_recipe);
    if($recipe_added){  
        $_SESSION['message']="Recipe Updated!"; 
        redirect_to('index.php');
                     
    }else{
     $_SESSION['message']="Could Not Edit Recipe"; 
        redirect_to('index.php');
    }//end insert recipe 
}//end check to see if recipe exists

if(isset($_POST['delete'])){    
     $id=addslashes($_POST['id']);  
    
 
    //creating new recipe
    $new_recipe="UPDATE recipes set trash=1 WHERE id = {$id}";
    $recipe_added=mysqli_query($connection, $new_recipe);
    if($recipe_added){  
        $_SESSION['message']="Recipe Deleted!"; 
        redirect_to('index.php');
                     
    }else{
     $_SESSION['message']="Could Not Delete Recipe"; 
        redirect_to('index.php');
    }//end insert recipe 
}//end check to see if recipe exists




 

//SHOW recipe SUBMITTED HISTORY
    if(isset($_GET['new'])){
    ?>
    <h1 id="center">New Recipe</h1>
    <br>
    <form id="new_recipe" action="#" method="POST">

        <input maxlength="50" type="text" name="name" placeholder="New Recipe Name (i.e. Chicken Tikka Masala)">
        
        <br>
        <br>
        <p>Adding ingredients coming soon!</p>
        <br>
        <input type="submit" name="add_recipe" value="Submit recipe">
    </form>
    <?php
    }else if(isset($_GET['compost'])){
 
        echo "<h1>Compost</h1>";
        echo "<a class=\"right\" href=\"index.php\">View Recipes</a>"; 
        echo "<ul id=\"list\">";
        $get_recipes="SELECT * FROM recipes WHERE trash=1 ORDER BY name";
        $recipes_found=mysqli_query($connection, $get_recipes);
        foreach($recipes_found as $recipe){  
            echo "<li><a href=\"recipe.php?id=".$recipe['id']."\">".$recipe['name']."</a>  <a title=\"RESTORE!\" href=\"index.php?restore=".$recipe['id']."\"><i class=\"fa fa-cutlery right\"></i></a> </li>";
        }
        echo "</ul>";
    
    }else if(isset($_GET['edit'])){
        $recipe_id=$_GET['edit'];
        $get_recipes="SELECT * FROM recipes WHERE id={$recipe_id}";
        $recipes_found=mysqli_query($connection, $get_recipes);
        $recipe_array=mysqli_fetch_assoc($recipes_found);
    ?>
    <h1 id="center">Edit Recipe</h1>
    <br>
    <form id="new_recipe" action="#" method="POST">

        <input maxlength="50" type="text" name="name" placeholder="New Recipe Name (i.e. Chicken Tikka Masala)" value="<?php echo $recipe_array['name']; ?>">
        <input  type="hidden" name="id"  value="<?php echo $recipe_array['id']; ?>">
        
        <br>
        <br>
        <p>Adding/Editing ingredients coming soon!</p>
        <br> 
        Cooking Instructions:<br>
        <textarea name="directions" id="" cols="30" rows="10" value="<?php echo $recipe_array['directions']; ?>"><?php echo $recipe_array['directions']; ?></textarea>
        <br>
        <input type="submit" name="edit_recipe" value="Submit recipe">
    </form>
    <br>
<hr/>
<h3 class="red">DANGER ZONE</h3><br/> 
<form action="index.php" method="POST">
    <input name="id" type="hidden" value="<?php echo $recipe_array['id']; ?>">
    <input name="delete" type="submit" value="Delete Recipe">
</form>
        <?php
    }elseif(isset($_GET['restore'])){    
     $id=addslashes($_GET['restore']);  
    
 
    //creating new recipe
    $new_recipe="UPDATE recipes set trash=0 WHERE id = {$id}";
    $recipe_added=mysqli_query($connection, $new_recipe);
    if($recipe_added){  
        $_SESSION['message']="Recipe Restored!"; 
        redirect_to('index.php');
                     
    }else{
     $_SESSION['message']="Could Not Restore Recipe"; 
        redirect_to('index.php');
    }//end insert recipe 
}else{
        echo "<h1>Recipes</h1>";
        echo "<a href=\"index.php?new\">+ New recipe</a><a class=\"right\" href=\"index.php?compost\">View Compost</a>"; 
        echo "<ul id=\"list\">";
        $get_recipes="SELECT * FROM recipes WHERE trash=0 ORDER BY name";
        $recipes_found=mysqli_query($connection, $get_recipes);
        foreach($recipes_found as $recipe){  
            echo "<li><a title=\"Add to shopping cart\" href=\"index.php?shopping_cart=".$recipe['id']."\"><i class=\"fa fa-cutlery right\">&nbsp;&nbsp;&nbsp; </i></a><a title=\"View Recipe\" href=\"recipe.php?id=".$recipe['id']."  \">  ".$recipe['name']."</a>  </li>";
        }
        echo "</ul>";
    
    }
?>