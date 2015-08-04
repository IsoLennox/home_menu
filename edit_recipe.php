<?php include('inc/header.php');

if(isset($_POST['submit'])){
    //EDITING recipe
    $recipe_id=$_POST['recipe_id'];
    $name=$_POST['name'];
    $content=$_POST['content'];
    $private=$_POST['private'];
    
                    
    $update_recipe  = "UPDATE recipes SET ";
    $update_recipe .= "name = '{$name}', content='{$content}', private={$private}  ";
    $update_recipe .= "WHERE id = {$recipe_id} ";
    $result = mysqli_query($connection, $update_recipe);
    if ($result && mysqli_affected_rows($connection) == 1) {
      // Success
                 $_SESSION["message"] = "recipe Updated!";
                redirect_to("recipes.php?recipe=".$recipe_id);
  
                
    } else {
      // Failure
                $_SESSION["message"] = "recipe Update Failed!";
                redirect_to("profile.php");
    }//END UPDATE ACCOUNT

}


if(isset($_GET['delete'])){
    //DELETING recipe
    //DELETE recipeS
    $recipe_id=$_GET['delete'];
    $date=date('m/d/Y');
    $update_recipe  = "UPDATE recipes SET trash=1, completed='{$date}' WHERE id = {$recipe_id} LIMIT 1";
    $result = mysqli_query($connection, $update_recipe);
    if ($result && mysqli_affected_rows($connection) == 1) {
      // Success
        
        $update_recipe  = "UPDATE recipes SET trash=1 WHERE recipe_id = {$recipe_id}";
        $result = mysqli_query($connection, $update_recipe);
        if ($result && mysqli_affected_rows($connection) == 1) {
                 $_SESSION["message"] = "recipe Deleted!";
                redirect_to("recipes.php?recipe=all");
        
        } else {
          // Failure
                $_SESSION["message"] = "recipe Deleted!";
                 redirect_to("recipes.php?recipe=".$recipe_id);
        }//END UPDATE ACCOUNT
  
                
    } else {
      // Failure
                $_SESSION["message"] = "recipe Update Failed!";
                 redirect_to("recipes.php?recipe=".$recipe_id);
    }//END UPDATE ACCOUNT


}


if(isset($_GET['restore'])){
    //DELETING recipe
    //DELETE recipeS
    $recipe_id=$_GET['restore'];
    $update_recipe  = "UPDATE recipes SET trash=0, completed='' WHERE id = {$recipe_id} LIMIT 1";
    $result = mysqli_query($connection, $update_recipe);
    if ($result && mysqli_affected_rows($connection) == 1) {
      // Success
        
        $update_recipe  = "UPDATE recipes SET trash=0 WHERE recipe_id = {$recipe_id}";
        $result = mysqli_query($connection, $update_recipe);
        if ($result && mysqli_affected_rows($connection) == 1) {
                 $_SESSION["message"] = "recipe Restored!";
                redirect_to("recipes.php?recipe=".$recipe_id);
        
        } else {
          // Failure
                $_SESSION["message"] = "recipe Restored";
                 redirect_to("recipes.php?recipe=".$recipe_id);
        }//END UPDATE ACCOUNT
  
                
    } else {
      // Failure
                $_SESSION["message"] = "recipe Could Not Be Restored!";
                 redirect_to("recipes.php?recipe=".$recipe_id);
    }//END UPDATE ACCOUNT


}
 
        $get_recipe="SELECT * FROM recipes WHERE id={$_GET['id']}";
        $recipe_result=mysqli_query($connection, $get_recipe); 
        if($recipe_result){
            $recipe_array=mysqli_fetch_assoc($recipe_result);
             echo "<h1> Editing recipe: ".$recipe_array['name']."</h1>";
            ?>
            <form action="#" method="POST">
               <h4>recipe Name</h4>
                <input type="hidden" name="recipe_id" value="<?php echo $recipe_array['id'];  ?>"> 
                <input type="text" name="name" value="<?php echo $recipe_array['name'];  ?>"><br/><br/>
                <h4>Private</h4>
               
                <input <?php if($recipe_array['private']==0){ echo "checked";  } ?> type="radio" name="private" value="0">No
                <input <?php if($recipe_array['private']==1){ echo "checked";  } ?> type="radio" name="private" value="1">Yes
                
                <br/><br/>
                <h4>recipe content</h4> 
                <textarea cols="50" rows="5" name="content" value="<?php echo $recipe_array['content'];  ?>"><?php echo $recipe_array['content'];  ?></textarea><br/><br/>
                <input type="submit" name="submit" value="SAVE">
            </form>
            <a href="recipes.php?recipe=<?php echo $recipe_array['id'];  ?>"> Cancel </a>
            <?php
        }
        
    
       
?>
<br>
<br>
<br>
<br>
<hr/>
<h3>DANGER ZONE</h3>
<a  href="edit_recipe.php?delete=<?php echo $_GET['id']; ?>">Delete recipe And ALL recipeS</a>
<?php



include('inc/footer.php'); ?>