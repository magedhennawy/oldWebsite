<?php
session_start();
	include("../../config.php");
      error_reporting(0);
      $user_id = $_GET['id'];

      // Check session of admin.If sesssion is not set die it.
      if(!isset($_SESSION['admin']))
  		{
         	$output['error']  = 'error';
         	$output['msg'] = "Session is destroyed";
         	die(json_encode($output));
  		}

      $query      =     "DELETE FROM `Exhibit` WHERE Exhibit=?";
      $parameters =     array($user_id);
      $statement  =     $db->prepare($query);
      $statement->execute($parameters);
      
      $error['msg'] ="deleted"; 
      echo json_encode($error);





?>
