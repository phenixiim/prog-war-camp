<?php



require('function.php');

if(isset($_GET['msg'])) {
    $messageFromGetParameterMsg = $_GET['msg'];

  processMessage($messageFromGetParameterMsg);
}