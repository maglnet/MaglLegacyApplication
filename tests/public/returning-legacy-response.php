<?php

$response = new \Zend\Http\Response();
$response->setContent('myResponse');
$response->setStatusCode(418);
return $response;
