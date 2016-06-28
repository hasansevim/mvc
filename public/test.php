<?php

require('../models/Actor.php');

$model = new $Actor();
$model->insert('JANE', 'JOBES');
if($model->errors) {
    $errors = $model->errors;
    echo current($errors);
}
echo "<pre>";
print_r($model);

?>