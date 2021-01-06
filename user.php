<?php

session_start();
include_once "php/comm.php";
include_once "php/db.php";
include_once "php/t_newsletter.php";
include_once "php/t_user.php";

//check user login data
if(isset($_POST["username"])
&& isset($_POST["userpass"])){
    DatabaseConnect();
    $usr = new TUser($GLOBALS['connection']);   
    $usr->getByName(htmlspecialchars($_POST["username"]));
    if($usr->getData("username")===htmlspecialchars($_POST['username'])
    && $usr->getData("password")===sha1(htmlspecialchars($_POST['userpass']))
    ){
        $_SESSION["UserLogged"] = $usr->getData("username");
    }
}

if(isset($_SESSION["UserLogged"])){
    //reading view config
    if(isset($_POST["login"])){
        $_SESSION["view"] = "dashboard";
    }
    if(isset($_POST["newsletter"])){
        $_SESSION["view"] = "newsletter";
    }
    if(isset($_POST["users"])){
        $_SESSION["view"] = "users";
    }
    if(isset($_POST["edituser"])){
        $_SESSION["view"] = "edituser";
    }
    if(isset($_POST["logout"])){
        $_SESSION["view"] = "logout";
    }
    
    //template selection and config
    if(isset($_SESSION["view"])){
        switch($_SESSION["view"]){
            case "newsletter":
                $_SESSION["viewTemplate"] = "templates/tmp_newsletter.php";
                $_SESSION["CurrentPage"]=1;
                break;
            case "users":
                $_SESSION["viewTemplate"] = "templates/tmp_users.php";
                $_SESSION["CurrentPage"]=1;
                break;
            case "dashboard":
                $_SESSION["viewTemplate"] = "templates/tmp_dashboard.php";
                $_SESSION["CurrentPage"]=1;
                break;
            case "edituser":
                $_SESSION["viewTemplate"] = "templates/tmp_edituser.php";
                break;
            default: 
                $_SESSION["viewTemplate"] = "templates/tmp_login.php";     
                $_SESSION = array();
                session_destroy(); 
        }
    }
}
else{
    $_SESSION["viewTemplate"] = "templates/tmp_login.php";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" 
        content="width=device-width, initial-scale=1.0,shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" 
        content="ie=edge">
    <link rel="icon" 
        href="img/favicon.png">
    <link rel="stylesheet"
        type="text/css"
        href="css/styles.min.css">
    <link rel="stylesheet"
        type="text/css"
        href="css/font-awesome.min.css">
    <title>Wild coffee</title>
</head>
<body class="font-text">
    <nav class="navbar navbar-expand-md navbar-light bg-light border-bottom border-secondary shadow-lg">
        <a href="index.html"
            class="navbar-brand">
            <img class="img-fluid"
                src="img/logo.png"
                alt="logo">
        </a>
        <button class="navbar-toggler"
            data-target="#main-nav"
            data-toggle="collapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main-nav">
            <ul class="navbar-nav ml-auto font-menu">
                <li class="nav-item active">
                    <a href="index.html"
                        class="nav-link">
                        Home
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#"
                        class="nav-link dropdown-toggle"
                        data-toggle="dropdown">
                        Products
                    </a>
                    <div class="dropdown-menu">
                        <a href="products/coffee.html"
                            class="dropdown-item">
                            Coffee
                        </a>
                        <a href="products/chocolate.html"
                            class="dropdown-item">
                            Hot Chocolate
                        </a>
                        <a href="products/brewing.html"
                            class="dropdown-item">
                            Brewing
                        </a>
                        <a href="products/spices.html"
                            class="dropdown-item">
                            Spices
                        </a>
                        <a href="products/sweets.html"
                            class="dropdown-item">
                            Sweets
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="about.html"
                        class="nav-link">
                        About
                    </a>
                </li>
                <li class="nav-item">
                    <a href="press.html"
                        class="nav-link">
                        Press
                    </a>
                </li>
                <li class="nav-item">
                    <a href="blog.html"
                        class="nav-link">
                        Blog
                    </a>
                </li>
                <li class="nav-item">
                    <a href="contact.html"
                        class="nav-link">
                        Contact
                    </a>
                </li>
                <li class="nav-item">
                    <a href="user.php"
                        class="nav-link">
                        <span class="fa fa-user-circle-o"></span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <section class="container-fluid user-s1 p-0">
        <?php if(isset($_SESSION["UserLogged"])){ ?>
        <div class="row font-menu w-100 mx-0">                    
            <ul class="breadcrumb w-100">
                <li class="breadcrumb-item">
                    <?php if(isset($_SESSION["UserLogged"])){echo $_SESSION["UserLogged"];} ?>
                </li>
                <li class="breadcrumb-item">
                    <?php if(isset($_SESSION["view"])){echo $_SESSION["view"];} ?>
                </li>
            </ul>
        </div>
        <?php 
            }
            if(isset($_SESSION["viewTemplate"])){
                include $_SESSION["viewTemplate"]; 
            }
            else{
                include "templates/tmp_login.php";
            }
        ?>      
    </section>
    <footer class="container-fluid bg-dark border-top border-secondary">
        <div class="row p-3">
            <div class="col-xs-12 col-sm-6 order-1 order-sm-0">
                <ul class="list-inline icon-list text-center text-sm-left my-0">
                    <li class="list-inline-item">
                        <a href="https://www.facebook.com"
                            rel="noreferrer noopener nofollow">
                            <span class="fa fa-facebook"></span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://www.twitter.com"
                            rel="noreferrer noopener nofollow">
                            <span class="fa fa-twitter"></span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://www.instagram.com"
                            rel="noreferrer noopener nofollow">
                            <span class="fa fa-instagram"></span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-xs-12 col-sm-6 order-0 order-sm-1">
                <div class="row">
                    <form class="form-newsletter text-white mx-auto mr-sm-0" 
                        action="newsletter.php"
                        autocomplete="off"
                        method="post"
                        required>
                        <div class="form-group font-header text-center text-sm-left">
                            <label>Join our mailing list</label>
                            <div class="input-group">
                                <input class="form-control" 
                                    maxlength="80"
                                    name="newsmail" 
                                    type="email"
                                    required>
                                <div class="input-group-append">
                                    <input  class="btn btn-outline-light" 
                                        type="submit" 
                                        value="Subscribe">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row mx-2 border-top border-secondary pt-1 font-menu">
            <div class="col-12 col-sm-6 text-center text-sm-left order-1 order-sm-0 p-1 p-sm-0">
                <small class="mx-auto mb-0 text-light">
                    Copyright &copy; 2019-2021 Tomasz Pankowski
                </small>
            </div>
            <div class="col-12 col-sm-6 text-center text-sm-right order-0 order-sm-1">
                <small>
                    <a href="privacy.html" class="link link-white">
                        Privacy &amp; Cookies
                    </a>
                </small>
            </div>
        </div>
    </footer>   
    <div class="modal" id="privacyModal">
        <div class="modal-dialog text-menu font-menu">
            <div class="modal-content p-2">
                <div class="modal-header text-center">
                    <h4 class="font-logo text-muted">GPDR Declaration</h4>
                    <a href="#privacyModal" 
                        data-target="#privacyModal"
                        data-dismiss="modal"
                        class="close">
                        &times;
                    </a>
                </div>
                <div class="modal-body">
                    <p class="initialism">
                        This website is a <span class="text-danger"> demo version </span> of real website,  It doesn't collect and process,
                        in long term meaning (longer than needed for website operation during visitor's
                        presence), any user (visitor) data.
                    </p>
                    <p class="initialism pt-2">
                         All information collected during visitor's 
                        presence on this website is used only for technical purposes, required for 
                        correct operation of website or demonstration purposes related to technical 
                        mechanisms and presentation of its operation... 
                        <a href="privacy.html" class="text-secondary">More about privacy</a>
                    </p>                        
                    <p class="initialism pt-2">
                        If you accept privacy policy please click button "accept". If you 
                        refuse it, leave page by closing it in your web browser, please.
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-dark mx-auto"
                        onclick="acceptPrivacyPolicy()">
                        Accept
                    </button>
                </div>
            </div>
        </div>
    </div>   
    <script type="text/javascript"
        src="js/main.min.js">
    </script>
</body>
</html>