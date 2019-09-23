
<div class="font-menu vh-100 p-3">      
    <form action=""
        autocomplete="off"
        class="form-user w-100 h-100"
        method="post">
        <div class="row h-100">
            <div class="col-12 col-sm-4 col-md-3">
                <div class="list-group">
                    <input class="list-group-item list-group-item-action"
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
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <small class="text-muted">Dashboard</small>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>  