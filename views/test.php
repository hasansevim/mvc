<?php

require_once('Actor.php');

//Initialize model
$model = new Actor();
$model->insert('JANE', 'JONES');
if($model->errors) {
    $errors = $model->errors;
    echo current($errors);
} 
//print out models
echo '<pre>';
echo print_r($model);