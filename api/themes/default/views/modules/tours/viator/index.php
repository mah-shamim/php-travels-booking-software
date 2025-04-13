<?php
    header('X-Frame-Options: GOFORIT');
    header('X-Frame-Options: ALLOW');
?>

<iframe sandbox="allow-same-origin allow-scripts allow-popups allow-forms" src="https://news.ycombinator.com/news" frameborder="0"></iframe>

<?php
$url = rawurldecode($_REQUEST['url']);
$header = get_headers($url, 1);
if(array_key_exists("X-Frame-Options", $header)){
    echo "nein";
}
else{
    echo "ya";
}
?>


<h1><?php echo $affid; ?></h1>
<h1><?php echo $iframeID; ?></h1>