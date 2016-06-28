<?php

// Required files
require_once('../classes/Database.php');
require_once('../models/Inventory.php');

class InventoryController {

    public function search() {
        $db = Database::connect(); // Connect to database

        $q = "";  // Initiate vars
        $posted = false;
        $results = array();

        if (isset($_POST['q'])) { // Check if form was posted
            $posted = true; // Set posted as true
            // Check if q is valid
            if (isset($_POST['q']) && $_POST['q']) { // q is valid
                $q = $_POST['q']; // Store the search query
                $inventory = new Inventory($db); // Initialize the Inventory class
                $inventory->searchStoreInventory($q);  // Process user search
                
                if ($inventory->errors) {    //Errors, display error information 
                    $errors = $inventory->errors;
                    die(current($errors));
                } else {
                    $results = $inventory->records; //No errors, store inventory records to results array for display 
                }
            }
        }
        include_once ("../views/inventory/search.php");
       // $db->close();  //close database connection
    }

    public function read() {

        $db = Database::connect();  // Get database connection
        
        $results = array(); //Initialize variables

        $inventory = new Inventory($db); // Initialize the Inventory class
        $inventory->displayStoreInventory(); // Get all inventory related records from the database
        
        if ($inventory->errors) {
            $errors = $inventory->errors;
            die(current($errors));
        } else {
            $results = $inventory->records;
        }
        include_once ('../views/inventory/read.php');
    }

}
