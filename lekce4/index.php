<?php

require('function.php');

if(isset($_GET['msg'])) {
  $vybornePojmenovanaPromenna = $_GET['msg'];

  processMessage($vybornePojmenovanaPromenna);
}

