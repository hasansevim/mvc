<?php

// Require classes
require_once('../classes/Database.php');
require_once('../models/Actor.php');

class ActorController {

    public function search() {
        // Connect to database
        $db = Database::connect();

        // Initiate vars
        $q = "";
        $posted = false;
        $results = array();

        // Check if form was posted
        if (isset($_POST['q'])) {

            // Set posted as true
            $posted = true;

            // Check if q is valid
            if (isset($_POST['q']) && $_POST['q']) { // q is valid
                // Store the search query
                $q = $_POST['q'];

                // Initialize the Actor class
                $actor = new Actor($db);

                // Process user search
                $actor->selectAdvancedSearch($q);
                if ($actor->errors) {
                    $errors = $actor->errors;
                    die(current($errors));
                } else {
                    $results = $actor->records;
                }
            }
        } 
        include_once('../views/actor/search.php');// include view
        $db->close();
    }

    public function read() {
        // Connect to database
        $db = Database::connect();
        
        $results = array(); // Initiate vars

        $actor = new Actor($db);
        //Retrieve all records from the database
        $actor->selectAll();
        if ($actor->errors) {
            $errors = $actor->errors;
            die(current($errors));
        } else {
            $results = $actor->records;
        }
        //include view 
        include_once('../views/actor/read.php');
        $db->close();
    }

    
    //create new record
    public function create($first_name, $last_name) {  
        
        $db = Database::connect(); //connect to database
        
        $posted= false; //Initialize variables
        $success = false; 
        $last_insert_id = "";
         
        if (isset($_POST['first_name']) && isset($_POST['last_name'])) {
            $posted = true;
            
            //If form was posted and had something
            if (isset($_POST['first_name']) && isset($_POST['last_name']) && ($_POST['first_name']) && ($_POST['last_name'])) {
               
                $first_name = $_POST['first_name'];//Store the posted items 
                $last_name = $_POST['last_name'];
                
                $actor = new Actor($db); //Initialize Actor class
                
                $actor->insert($first_name, $last_name); //Call insert method to insert new record into database
                 
                if ($actor->errors) {  //error inserting a new record
                    die(current($actor->$errors));
                } else {
                    $success = true;    //New record inserted into database
                    $last_insert_id = $db->insert_id;  //Obtain the new record id for display
                }
            }
        }
       include_once('../views/actor/create.php'); //include view
       $db->close();
    }
    
    public function delete($id) {
        
        $db = Database::connect();  //set up database connection
        $del_submitted = false;  //initialize variables
        $del_success = false; 
        
        if(isset($_GET['id'])) {
            $del_submitted = true; 
           
            if(isset($_GET['id']) && ($_GET['id'])) {
                $id = $_GET['id'];
                $actor = new Actor($db);
                $actor->delete($id);
                
                if($actor->errors) {
                    die (current($actor->errors));
                } else {
                    $del_success = true; 
                }
            }
        }
       include_once ('../views/actor/delete.php'); 
       $db->close();
    }
    
    public function update($first_name, $last_name, $id) {
        
        $db = Database::connect();  //connec to database
        $posted = false; 
        $updated = false; 
        
        if(isset($_POST['id']) && isset($_POST['first_name']) && isset($_POST['last_name'])){
            $posted = true; 
            if($_POST['id'] && $_POST['first_name'] && $_POST['last_name']) {
                $id = $_POST['id'];
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                
                $actor = new Actor($db);
                $actor->update($first_name, $last_name, $id);
                
                if($actor->errors) {
                    die(current($actor->errors));
                } else {
                    $updated  = true; 
                }
            }
        }
      include_once ('../views/actor/update.php');
      $db->close();
    }
}

?>