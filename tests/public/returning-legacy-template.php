<?php

$model = new \Laminas\View\Model\ViewModel(array('foo' => "bar"));
$model->setTemplate('legacy-template');
return $model;
