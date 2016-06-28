<?php

// Required files
require_once('../classes/Database.php');
require_once('../models/Rental.php');

class RentalController {
    public function search() {
        $db = Database::connect();// Connect to database
        
        // Initiate vars
        $q = "";
        $posted = false;
        $results = array();

        // Check if form was posted
        if (isset($_POST['q'])) {
            $posted = true; // Set posted as true

            // Check if q is valid
            if (isset($_POST['q']) && $_POST['q']) { // q is valid
               
                $q = $_POST['q']; // Store the search query
                $rental = new Rental($db); // Initialize the Actor class
                $rental->searchCustomerRentals($q); // Process user search
                if ($rental->errors) {
                    $errors = $rental->errors;
                    die(current($errors));
                } else {
                    $results = $rental->records;
                }
            }
        } 
        include_once('../views/rental/search.php');
        $db->close();
    }
    
    
    public function read() {
          $db = Database::connect();   //Connect to database
             
          $results = array();  //Initialize variables
          
            $rental = new Rental($db); // Initialize the Actor class
            $rental->selectAllCustomerRentals(); // Get all customer records from the database
            
            if ($rental->errors) {
                $errors = $rental->errors;
                die(current($errors));
            } else {
                $results = $rental->records;
            }
        include_once ('../views/rental/read.php');
        $db->close() ; //close database connection
    }

}
