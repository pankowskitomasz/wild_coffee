<?php

class TNewslettter{
    private $link;

    private function checkEmailPresence($emailA){
        $stmt = $this->link->prepare("select id from newsletter where email=:emailAddr");
        $stmt->bindParam(":emailAddr",$emailA);
        $stmt->execute();
        return is_array($stmt->fetch(PDO::FETCH_ASSOC))?true:false;
    }

    private function deleteEmail($emailA){
        $stmt = $this->link->prepare("delete from newsletter where email=:emailAddr");
        $stmt->bindParam(":emailAddr",$emailA);
        return $stmt->execute();
    }

    private function insert($emailA){
        $stmt = $this->link->prepare("insert into newsletter(email) values(:emailAddr)");
        $stmt->bindParam(":emailAddr",$emailA);
        return $stmt->execute();
    }

    public function __construct($dbLinkA=null){
        $this->link = $dbLinkA;
    }

    public function getDBLink(){
        return $this->link;
    }

    public function getList(){
        $stmt = $this->link->prepare("select * from newsletter");
        $stmt->execute();
        $res = $stmt->fetchAll();
        return $res;
    }

    public function getListLength(){
        $stmt = $this->link->prepare("select count(*) from newsletter");
        $stmt->execute();
        $res = $stmt->fetchAll();
        return $res[0][0];
    }

    public function setDBLink($dbLinkA=null){
        $this->link = (isset($dbLinkA))?$dbLinkA:null;        
    }

    public function subscribe($emailA=null){
        if(isset($emailA)
        && isset($this->link)
        && filter_var($emailA,FILTER_VALIDATE_EMAIL)){  
            if($this->checkEmailPresence($emailA)){
                return "Subscription already actived";
            }
            else{
                return ($this->insert($emailA))?"Subscription activated":"Subscription failed";
            }
        }
        return "Incorrect email";
    }

    public function unsubscribe($emailA=null){
        if(isset($emailA)
        && isset($this->link)
        && filter_var($emailA,FILTER_VALIDATE_EMAIL)){   
            if($this->checkEmailPresence($emailA)){
                return ($this->deleteEmail($emailA)===true)?"Subscription removed":"Subscription canceling failed";
            }
            return "Subscription already removed";
        }
    }

}
?>