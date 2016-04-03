<?php
////// CONTAINS SCRIPTS to SIMPLIFY OTHER PAGE CODE //////
function connectMySQL () {
    $hostname = '';
    $username = '';
    $password = '';
    $dbName = '';
    
    try {
        $dbh = new PDO("mysql:host=$hostname;
        dbname=$dbName", $username, $password);
        
        $dbh->setAttribute(PDO::ATTR_ERRMODE, 
                           PDO::ERRMODE_EXCEPTION);
        return $dbh;
    }
    
    catch(Exception $e) {
        $message = 'We are unable to process your request. 
        Please contact LARM webadmin for assistance';
    }
}
//////////////////////// end connectMySQL()
function deleteMessage($id) {
    $message = "";
    
    try {
        $dbh = connectMySQL();
        $stmt = $dbh->prepare("UPDATE `messages` SET `deleted` = '1' 
        WHERE id=:id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        $message = "Message deleted";
    }
    
    catch (Exception $e) {
        $message = "Message deletion failed.  Please contact webadmin for assistance";
    }
    
    return $message;
}
//////////////////////// end deleteMessage()
function markRead($id) {
    $dbh = connectMySQL();
    $stmt = $dbh->prepare("UPDATE `messages` SET `read` = '1' WHERE id=:id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}
    
//////////////////////// end markRead()
function getMessage($id) {
    $message = "";
    
    try {
        $dbh = connectMySQL();
        $stmt = $dbh->prepare("SELECT `message` FROM `messages` WHERE id=:id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $query = $stmt->fetchall(PDO::FETCH_COLUMN);
        
        $message = $query[0];
    }
    
    catch (Exception $e) {
        $message = "Could not open message.  Please contact webadmin for assistance";
    }
    
    return $message;
}
//////////////////////// end getMessage()
function getInbox($currentUser) {
    
    $inboxMessages = array();
    $dbh = connectMySQL();
    
    try {
        $stmt = $dbh->prepare("SELECT * FROM messages WHERE recipient_id= :recipient_id AND deleted = 'false'");
        $stmt->bindParam(':recipient_id', $currentUser, PDO::PARAM_INT);
        $stmt->execute();
        $inboxMessages = $stmt->fetchall(PDO::FETCH_ASSOC);
        
        $message = "Records found successfully";
        
    }
    catch (Exception $e) {
        $message = "Records not found successfully.  Please contact webadmin for assistance";
    }
        
    $dbh = null;
    return $inboxMessages;
    
}
function getSent($currentUser) {
    
    $sentMessages = array();
    $dbh = connectMySQL();
    
    try {
    
        $stmt = $dbh->prepare("SELECT * FROM messages WHERE sender_id= :sender_id AND deleted = 'false'");
        
        $stmt->bindParam(':sender_id', $currentUser, PDO::PARAM_INT);
        $stmt->execute();
        $sentMessages = $stmt->fetchall(PDO::FETCH_ASSOC);
        
        $message = "Records found successfully";
        
    }
    catch (Exception $e) {
        $message = "Records not found successfully.  Please contact webadmin for assistance";
    }
        
    $dbh = null;
    return $sentMessages;
    
}
?>