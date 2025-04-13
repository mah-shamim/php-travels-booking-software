<?php

// route for admin
$router->get('admin', function() {
header("Location: ".api_url."admin");
});

// route for supplier
$router->get('supplier', function() {
header("Location: ".api_url."supplier");
});