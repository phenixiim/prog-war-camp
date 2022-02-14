<?php
if(isset($_POST) && !empty($_POST)) {
    require('processing.php');
} else {
    require('form.php');
}