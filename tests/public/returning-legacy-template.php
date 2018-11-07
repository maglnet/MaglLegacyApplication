<?php

$model = new \Zend\View\Model\ViewModel(array('foo' => "bar"));
$model->setTemplate('legacy-template');
return $model;
