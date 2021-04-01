<?php

$response = new \Laminas\Http\Response();
$response->setContent('myResponse');
$response->setStatusCode(418);
return $response;
