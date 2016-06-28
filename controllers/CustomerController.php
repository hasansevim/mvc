<?php

// Required classes
require_once('../classes/Database.php');
require_once('../models/Customer.php');

class CustomerController {
    
    public function search() {
        // Connect to database
        $db = Database::connect();

        //Initialize variables
        $q = "";
        $posted = false;
        $results = array();
      
        //Check if the form was posted
        if (isset($_POST['q'])) {
            $posted = true;

            if (isset($_POST['q']) && $_POST['q']) {  //check if q is valid
                $q = $_POST['q'];  //Store the search query 

                $customer = new Customer($db); //Initialize the customer class
                $customer->selectBasicSearch($q); //Process user search

                if ($customer->errors) {
                    die(current($customer->errors));
                } else {
                    $results = $customer->records;
                }
            }
        } 
        include_once('../views/customer/search.php'); // include view
        $db->close();   //close database connection
    }  //End search function 
    
    public function read() {
        //Initialize variables 
        $results = array();
        
        $db = Database::connect(); //Connect to databast

        $customer = new Customer($db);
        $customer->displayAll();
        if($customer->errors) {
            $errors = $customer->errors;
            die(current($errors));
        } else {
            $results = $customer->records;
        }
        include_once('../views/customer/read.php');   //include the view
        $db->close();   //close database connection
    }   
    
}

?>