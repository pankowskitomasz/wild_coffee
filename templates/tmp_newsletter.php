<?php

DatabaseConnect();
$news = new TNewslettter($GLOBALS['connection'],'newsletter');

//check subscription related actions
if(isset($_POST["unsubscribe"])){
    $news->unsubscribe(htmlspecialchars($_POST["unsubscribe"]));
}
else if(isset($_POST["subscribe"]) && isset($_POST["subsemail"])
|| (!empty($_POST["subsemail"]) && filter_var($_POST["subsemail"], FILTER_VALIDATE_EMAIL))){
    $news->subscribe(htmlspecialchars($_POST["subsemail"]));
}

//handling newsletter list pagination
if(!isset($_SESSION["CurrentPage"])){
    $_SESSION["CurrentPage"]=1;
}
else{
    if(isset($_POST["prevpage"])
    && $_SESSION["CurrentPage"]>1){
        $_SESSION["CurrentPage"]--;
    }
    if(isset($_POST["nextpage"])
    && $_SESSION["CurrentPage"]<(ceil($news->getListLength()/PAGE_SIZE))){
        $_SESSION["CurrentPage"]++;
    }
}

?>
<div class="font-menu p-3">      
    <form action=""
        autocomplete="off"
        class="form-user w-100 h-100"
        method="post">
        <div class="row h-100">
            <div class="col-12 col-sm-4 col-md-3 mb-3">
                <div class="list-group">
                    <input class="list-group-item list-group-item-action list-group-item-secondary"
                        name="newsletter"
                        type="submit"
                        value="Newsletter">  
                    <?php 
                        if(isset($_SESSION["UserLogged"])
                        && $_SESSION["UserLogged"]==="administrator"){
                    ?>                      
                    <input class="list-group-item list-group-item-action"
                        name="users"
                        type="submit"
                        value="Users">         
                    <?php } ?>
                    <input class="list-group-item list-group-item-action"
                        name="logout"
                        type="submit"                                
                        value="Logout">
                </div>
            </div>
            <div class="col-12 col-sm-8 col-md-9">
                <div class="card w-100 mb-3">
                    <div class="card-body">
                        <label class="">Add email address</label>
                        <div class="input-group">
                            <input class="form-control text-center"
                                name="subsemail"
                                tabindex="1"
                                type="email">
                            <div class="input-group-append">
                                <button class="btn btn-outline-dark"
                                    name="subscribe"
                                    tabindex="2"
                                    type="submit">
                                    Subscribe
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn-group float-right mb-2">
                    <button class="btn btn-sm btn-outline-secondary"
                        name="prevpage"
                        type="submit">
                        &lt;
                    </button>
                    <button class="btn btn-sm btn-outline-secondary"                        
                        disabled>
                        <?php 
                            if(isset($_SESSION["CurrentPage"])){
                                echo $_SESSION["CurrentPage"]." / ".ceil($news->getListLength()/PAGE_SIZE);
                            } 
                        ?>
                    </button>
                    <button class="btn btn-sm btn-outline-secondary"
                        name="nextpage"
                        type="submit">
                        &gt;
                    </button>
                </div>
                <div class="card w-100">
                    <div class="card-body p-0">
                        <table class="table table-hover table-striped m-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th colspan="2">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $tab = $news->getList();
                                    $pstart = ($_SESSION["CurrentPage"]-1)*PAGE_SIZE;
                                    $pend = $pstart+(PAGE_SIZE);
                                    for($i=$pstart;$i<count($tab) && $i<$pend;$i++){
                                        echo "<tr><td>".$tab[$i][0]."</td>".
                                            "<td>".$tab[$i][1]."</td><td>".
                                            "<button type='submit' name='unsubscribe' class='btn btn-sm btn-danger float-right' value='".$tab[$i][1]."'>Remove</button>".
                                            "</td></tr>";
                                    }
                                ?>    
                            </tbody>
                        </table>                
                    </div> 
                </div>                   
                <div class="btn-group float-right mt-2">
                    <button class="btn btn-sm btn-outline-secondary"
                        name="prevpage"
                        type="submit">
                        &lt;
                    </button>
                    <button class="btn btn-sm btn-outline-secondary"                        
                        disabled>
                        <?php 
                            if(isset($_SESSION["CurrentPage"])){
                                echo $_SESSION["CurrentPage"]." / ".ceil($news->getListLength()/PAGE_SIZE);
                            } 
                        ?>
                    </button>
                    <button class="btn btn-sm btn-outline-secondary"
                        name="nextpage"
                        type="submit">
                        &gt;
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>  