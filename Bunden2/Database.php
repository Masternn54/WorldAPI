<?php
//request method hvis det ikke er get så exiter den
$method = $_SERVER['REQUEST_METHOD'];
if ($method != 'GET') {
    echo "Only supports get methods";
    exit;
}
//tager indholdet fra query string og parser dem og hvis arryet ikke findes så exiter den
$queryParams = [];
parse_str($_SERVER['QUERY_STRING'], $queryParams);
if  (!array_key_exists('name', $queryParams)) {
    echo "Query Param name must be specified";
    exit;
}

// connect to the mysql database
$link = mysqli_connect('localhost', 'root', 'root', 'world');
mysqli_set_charset($link,'utf8');

// create SQL based on HTTP method
$sql = "select * FROM country WHERE Name = " . $queryParams['name'];

// excecute SQL statement
$result = mysqli_query($link,$sql);

// die if SQL statement failed
if (!$result) {
    http_response_code(404);
    die(mysqli_error());
}

echo json_encode($result->fetch_assoc());

// close mysql connection
mysqli_close($link);

