<?php
$baseGoogleUrl = 'https://www.google.com/search?q=';
$resultsUrl = $baseGoogleUrl.urlencode($_GET['query']);
$html = file_get_contents($resultsUrl);
echo $html;





