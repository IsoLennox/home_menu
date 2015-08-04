<?php include('inc/header.php'); 

if(isset($_GET['id'])){
    $recipe_id=$_GET['id'];
}else{
    redirect_to('index.php');
}
 
       
        
$get_recipes="SELECT * FROM recipes WHERE id={$recipe_id}";
        $recipes_found=mysqli_query($connection, $get_recipes); 
        foreach($recipes_found as $recipe){
            echo "<h1>".$recipe['name']."</h2>";
            echo "<ul class=\"inline\"><li>Add to Cart</li><li><a href=\"index.php?edit=".$recipe['id']."\">Edit Recipe</a></li></ul>";
            $directions=$recipe['directions'];
        } 
        
        
       
$get_ingredients="SELECT * FROM resipe_ingredients WHERE recipe_id={$recipe_id} ORDER BY name";
        $ingredients_found=mysqli_query($connection, $get_ingredients);
if($ingredients_found){
     echo "<h3>Ingredients:</h3>";
        echo "<ul id=\"list\">";
        foreach($ingredients_found as $ingredient){
            $food_type_found=food_type_by_id($ingredient['food_type_id']);
            echo "<li>".$ingredient['name']." (".$food_type_found['name'].") <a href=\"ingredients.php?remove=".$ingredient['id']."\"><i class=\"fa fa-trash-o red right\"></i></a></li>";
        }
     echo "</ul>";
}else{
    echo "Please edit this recipe to add your first ingredient!";
}
       echo "<div class=\"content\">Cooking Directions:<br/><br/>".nl2br($directions)."</div>";
  
?>