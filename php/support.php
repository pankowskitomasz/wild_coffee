<?php

function createAdminAccount($passA,$mailA,$pinA){
    DatabaseConnect();
    $usr = new TUser($GLOBALS['connection']);   
    $usr->setData("username","administrator");
    $usr->setData("password",sha1($passA));
    $usr->setData("email",$mailA);
    $usr->setData("pin",$pinA);
    $usr->saveUser();
}

function resetUserCounter(){
    DatabaseConnect();
    $stmt = $GLOBALS['connection']->prepare("alter table users auto_increment=1");
    $stmt->execute();   
}

function resetNewsletterCounter(){
    DatabaseConnect();
    $stmt = $GLOBALS['connection']->prepare("alter table newsletter auto_increment=1");
    $stmt->execute();   
}
//resetUserCounter();
//resetNewsletterCounter();
//createAdminAccount("password","admin@wildcoffee.com","9731");

?>