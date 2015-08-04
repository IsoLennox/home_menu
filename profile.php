<?php include('inc/header.php'); ?>
 <?php
    
    if (isset($_POST['submit'])) {
        
    $user_query  = "SELECT * FROM users WHERE id={$_SESSION['user_id']}";  
    $user_result = mysqli_query($connection, $user_query);
    $num_rows=mysqli_num_rows($user_result);
    if($num_rows >= 1){
        $user_data=mysqli_fetch_assoc($user_result); 
        $stored_pass=$user_data['password'];
 
    } 
        
    $old_pass = mysql_prep($_POST["old_pass"]);
        
        
    if (password_verify($old_pass, $stored_pass)){
		
            //old password matched current password
            $hashed_password = password_hash($_POST["new_pass"], PASSWORD_DEFAULT);
            $first_password = $_POST["new_pass"];
            $confirmed_password = $_POST["confirm_pass"];
  
   if(!empty($first_password) && !empty($confirmed_password)){
            if($first_password===$confirmed_password){
                //new passwords match
                //perform update with $hashed_pass
                
    $update_pass  = "UPDATE users SET ";
    $update_pass .= "password = '{$hashed_password}' ";
    $update_pass .= "WHERE id = {$_SESSION['user_id']} ";
    $result = mysqli_query($connection, $update_pass);
    if ($result && mysqli_affected_rows($connection) == 1) {
      // Success
        
        //CHANGE USERNAME
        
                      
    $update_username  = "UPDATE users SET ";
    $update_username .= "username = '{$_POST['username']}', ";
    $update_username .= "email = '{$_POST['email']}' ";
    $update_username .= "WHERE id = {$_SESSION['user_id']} ";
    $usernameresult = mysqli_query($connection, $update_username);
    if ($usernameresult && mysqli_affected_rows($connection) == 1) {
      // Success
            $_SESSION["message"] = "Username, Email, and Password Updated! ";
            $_SESSION['username']=$_POST['username'];
                redirect_to("profile.php");
    } else {
      // Failure
                $_SESSION["message"] = "Password Changed. Username and Email Not Updated";
                redirect_to("profile.php");
    }//END UPDATE ACCOUNT
        
        
                
    } else {
      // Failure
                $_SESSION["message"] = "Password Update Failed!";
                redirect_to("profile.php");
    }//END UPDATE ACCOUNT
                


            }else{
                $_SESSION["message"] = "Passwords Do Not Match!";
                redirect_to("profile.php");
            }//end update new password
        
    }else{
       $_SESSION["message"] = "Passwords Cannot be blank!";
                      redirect_to("profile.php");
 
        }  
            }else{
                $_SESSION["message"] = "Old Password Incorrect";
                      redirect_to("profile.php");
            }//end if old password is correct current password
    }//end submit new password



if(isset($_GET['id'])){ 
    $user_id=$_GET['id'];
}else{
    $user_id=$_SESSION['user_id'];
}
    
    $user_query  = "SELECT * FROM users WHERE id={$user_id}";  
    $user_result = mysqli_query($connection, $user_query);
    $num_rows=mysqli_num_rows($user_result);
    if($num_rows >= 1){
        $user_data=mysqli_fetch_assoc($user_result);  
        echo "<h1>".$user_data['username']."</h1>";
        
 
       
       
       
        if( $user_id==$_SESSION['user_id']){       ?>
            
            
                 <ul class="accordian">
                        <li>
                        <?php if($recipe['trash']==0){ ?>
                        <button class="no-float accordian-control"><i class="fa fa-wrench"> </i> Edit Your Account</button>
                        <?php }  ?>
                        <div class="accordian-panel">
                            <h3>Reset Username, Email, and Password</h3>
                            <form method="POST" action="profile.php" >
                              <?php
                            $get_email=find_user_by_id($_SESSION['user_id']);
                        ?>
                               <input type="text" name="username" value="<?php echo $_SESSION['username']; ?>" placeholder="NEW NAME"><br/><br/>
                               <input type="text" name="email" value="<?php echo $get_email['email']; ?>" placeholder="NEW EMAIL"><br/><br/>
                                <input type="password" name="old_pass" placeholder="OLD PASSWORD"><br/><br/>
                                <p>If not changing your password, please re-enter your old one:</p>
                                <input type="password" name="new_pass" placeholder="NEW PASSWORD"><br/><br/>
                                <input type="password" name="confirm_pass" placeholder="CONFIRM NEW PASSWORD"><br/><br/>
                                <input type="submit" name="submit" value="Save">
                            </form>
                        </div>
                        </li>
                        </ul><?php
        }
        if ($_SESSION['admin']==1 ){    
//        echo "<h4 class=\"right\"><i class=\"fa fa-trash red\"></i> Remove this user</h4>";
        }
        echo "<h3>recipes by this user</h3><hr/>";
        $user_recipes  = "SELECT * FROM recipes WHERE created_by={$user_id}";  
        $recipe_result = mysqli_query($connection, $user_recipes);
        foreach($recipe_result as $recipe){
                echo "<a href=\"recipes.php?id=".$recipe['id']."\">".$recipe['name']."</a><br/>";
        }
        
    } ?>

<script>
                //        ON CLICK ACCORDIAN 

            $('.accordian').on('click', '.accordian-control', function(e) {
                e.preventDefault();
                $(this)
                    .next('.accordian-panel')
                    .slideToggle("slow");
            });
</script>
    
</body>
</html>