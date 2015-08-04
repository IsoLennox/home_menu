<?php ob_start();

function redirect_to($new_location) {
    header("Location: " . $new_location);
	  exit; }

function mysql_prep($string) {
	global $connection;

	$escaped_string = mysqli_real_escape_string($connection, $string);
	return $escaped_string;
} //end mysql_prep

function get_suffix($day) {
	$suffixes = array('th','st','nd','rd','th','th','th','th','th','th');
	if (($day % 100) >= 11 && ($day % 100) <= 13)
	   $ordinal = $day . 'th';
	else
	   $ordinal = $day . $suffixes[$day % 10];
	return $ordinal;
} //end get_suffix

function attempt_login($email, $password) {
	//find user, then password
	$user = find_user_by_email($email);
	if ($user) {
		//found admin, check password
		if (password_verify($password, $user["password"])) {
			//password matches
			return $user;
		} else {
			//password doesn't match
			echo "bad password<br>";
			return false;
		}
	} else {
		//not found
		return false;
	}
} //end attempt_login

function logged_in(){
    return isset($_SESSION['user_id']);
}

function confirm_logged_in(){
    if (!logged_in()){
        redirect_to("login.php");
//        $_SESSION['admin']=0;
    }else{
//        $_SESSION['admin']=1;
    }
}	

function find_user_by_email($email) {
	global $connection;
	$safe_email = mysql_prep($email);

	$sql = "SELECT * ";
	$sql .= "FROM users ";
	$sql .= "WHERE email = '{$safe_email}' ";
	$sql .= "LIMIT 1";

	$user_set = mysqli_query($connection, $sql);
	if ($user = mysqli_fetch_assoc($user_set)) {
		return $user;
	} else {
		return null;
	}
} //end find_user_by_email


function find_user_by_username($username) {
	global $connection;
	$safe_username = mysql_prep($username);

	$sql = "SELECT * ";
	$sql .= "FROM users ";
	$sql .= "WHERE username = '{$safe_username}' ";
	$sql .= "LIMIT 1";

	$user_set = mysqli_query($connection, $sql);
	if ($user = mysqli_fetch_assoc($user_set)) {
		return $user;
	} else {
		return null;
	}
} //end find_user_by_username



function find_user_by_id($user_id) {
	global $connection;
	$safe_user_id = mysql_prep($user_id);

	$sql = "SELECT * ";
	$sql .= "FROM users ";
	$sql .= "WHERE id = '{$safe_user_id}' ";
	$sql .= "LIMIT 1";

	$user_set = mysqli_query($connection, $sql);
	if ($user = mysqli_fetch_assoc($user_set)) {
		return $user;
	} else {
		return null;
	}
} //end find_user_by_id

function food_type_by_id($food_type_id) {
	global $connection;
	$safe_id = mysql_prep($food_type_id);

	$sql = "SELECT * ";
	$sql .= "FROM food_types ";
	$sql .= "WHERE id = '{$safe_id}' ";
	$sql .= "LIMIT 1";

	$user_set = mysqli_query($connection, $sql);
	if ($user = mysqli_fetch_assoc($user_set)) {
		return $user;
	} else {
		return null;
	}
} //end find_user_by_id


function find_type_by_id($alert_id) {
	global $connection;
	$safe_alert_id = mysql_prep($alert_id);

	$sql = "SELECT * ";
	$sql .= "FROM alert_types ";
	$sql .= "WHERE id = '{$safe_alert_id}' ";
	$sql .= "LIMIT 1";

	$user_set = mysqli_query($connection, $sql);
	if ($user = mysqli_fetch_assoc($user_set)) {
		return $user;
	} else {
		return null;
	}
} //end find_user_by_id

function form_errors($errors=array()) {
    $output = "";
    if (!empty($errors)) {
        $output = "<div class=\"error\">";
        $output .= "Please fix the following errors:";
        $output .= "<ul>";
        foreach ($errors as $key => $error) {
            $output .= "<li>";
            $output .= htmlentities($error);
            $output .= "</li>";
        }
        $output .= "</ul>";
        $output .= "</div>";
    }
    return $output;
}



?>