<?php require_once("inc/session.php"); 
require_once("inc/functions.php"); 
include('inc/db_connection.php');  
confirm_logged_in();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Home Menu</title>
        <link rel="stylesheet" href="css/style.css"> 
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet' type='text/css'>
    </head>

    <body>
      <?php
        //GET SEARCH QUERY IF USER USED SEACH BAR
            if(isset($_POST['query'])){ 
            $query=$_POST['query'];
            }else{
            $query="";
            } ?>


        <header>
            <h1>Home Menu</h1> 
               <form class="search" action="search.php" method="POST">
<input class="searchTerm" name="query" placeholder="Search recipes" value="<?php echo $query; ?>" />
<input class="searchButton" type="submit" name="recipes" />
</form>
                <nav>
                    <ul>
<!--
                        <a href="members.php">
                            <li>Members</li>
                        </a>
-->

                        <a href="index.php">
                            <li>Recipes</li>
                        </a>
                        
                         <a href="index.php?lists">
                            <li>Saved Lists</li>
                        </a>

<!--
                        <a href="new_recipe.php">
                            <li>New Recipe</li>
                        </a> 
-->
                        <a href="ingredients.php">
                            <li>Ingredients</li>
                        </a> 
                        <?php $this_user=find_user_by_id($_SESSION['user_id']); ?>
                            <a class="green_text" href="profile.php">
                                <li>  
                                    <?php echo $_SESSION['username']; ?>
                                </li>
                            </a> 
                            <a class="right" href="logout.php">
                                <li>Logout</li>
                            </a>
                    </ul>
                </nav>
            
              

        </header>
        <hr>
        <nav id="sidenav">
            <h2>Shopping Cart</h2>
            <ul>
                <li>Recipe name (x)</li>
            </ul>
            <input type="submit" value="Create List">
          
        </nav>
   
                

 
        
      

        <script>
//            HIDEY HEADER JIMMY
            /*
             * HeadsUp 1.5.6
             * @author Kyle Foster (@hkfoster)
             * @license MIT
             */
            ;
            (function(window, document, undefined) {

                'use strict';

                // Extend function
                function extend(a, b) {
                    for (var key in b) {
                        if (b.hasOwnProperty(key)) {
                            a[key] = b[key];
                        }
                    }
                    return a;
                }

                // Throttle function (http://bit.ly/1eJxOqL)
                function throttle(fn, threshhold, scope) {
                    threshhold || (threshhold = 250);
                    var previous, deferTimer;
                    return function() {
                        var context = scope || this,
                            current = Date.now(),
                            args = arguments;
                        if (previous && current < previous + threshhold) {
                            clearTimeout(deferTimer);
                            deferTimer = setTimeout(function() {
                                previous = current;
                                fn.apply(context, args);
                            }, threshhold);
                        } else {
                            previous = current;
                            fn.apply(context, args);
                        }
                    };
                }

                // Class management functions
                function classReg(className) {
                    return new RegExp('(^|\\s+)' + className + '(\\s+|$)');
                }

                function hasClass(el, cl) {
                    return classReg(cl).test(el.className);
                }

                function addClass(el, cl) {
                    if (!hasClass(el, cl)) {
                        el.className = el.className + ' ' + cl;
                    }
                }

                function removeClass(el, cl) {
                    el.className = el.className.replace(classReg(cl), ' ');
                }

                // Main function definition
                function headsUp(selector, options) {
                    this.selector = document.querySelector(selector);
                    this.options = extend(this.defaults, options);
                    this.init();
                }

                // Overridable defaults
                headsUp.prototype = {
                    defaults: {
                        delay: 300,
                        sensitivity: 20
                    },

                    // Init function
                    init: function(selector) {

                        var self = this,
                            options = self.options,
                            selector = self.selector,
                            oldScrollY = 0,
                            winHeight;

                        // Resize handler function
                        function resizeHandler() {
                            winHeight = window.innerHeight;
                            return winHeight;
                        }

                        // Scroll handler function
                        function scrollHandler() {

                            // Scoped variables
                            var newScrollY = window.pageYOffset,
                                docHeight = document.body.scrollHeight,
                                pastDelay = newScrollY > options.delay,
                                goingDown = newScrollY > oldScrollY,
                                fastEnough = newScrollY < oldScrollY - options.sensitivity,
                                rockBottom = newScrollY < 0 || newScrollY + winHeight >= docHeight;

                            // Where the magic happens
                            if (pastDelay && goingDown) {
                                addClass(selector, 'heads-up');
                            } else if (!goingDown && fastEnough && !rockBottom || !pastDelay) {
                                removeClass(selector, 'heads-up');
                            }

                            // Keep on keeping on
                            oldScrollY = newScrollY;
                        }

                        // Attach listeners
                        if (selector) {

                            // Trigger initial resize
                            resizeHandler();

                            // Resize function listener
                            window.addEventListener('resize', throttle(resizeHandler), false);

                            // Scroll function listener
                            window.addEventListener('scroll', throttle(scrollHandler, 100), false);
                        }
                    }
                };

                window.headsUp = headsUp;

            })(window, document);

            // Instantiate HeadsUp
            new headsUp('.main-header');


            //FADE OUT SESSION MESSAGES
            setTimeout(function() {
                $(".message").fadeOut(800);
            }, 5000);
        </script>



<div id="page">

<?php echo message(); ?>  