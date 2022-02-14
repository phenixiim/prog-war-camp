<?php

require('function.php');

if(!isset($_POST) || empty($_POST['districtSelect'])) {
    echo('Chybně vyplněný formulář!');
    die;
}

$citiesInDistrict = getCitiesInTheDistrict($_POST['districtSelect']);

if(count($citiesInDistrict) == 0) {
    echo('Chybně vyplněný formulář!');
    die;
}

echo('<h1>Seznam měst pro vybraný kraj `'.$_POST['districtSelect'].'`</h1>');
foreach ($citiesInDistrict as $city) {
    echo $city;
    echo '<br/>';
}