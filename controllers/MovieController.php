<?php

 //Required classes
require_once ('../classes/Database.php');
require_once ('../models/Movie.php');

class MovieController {

    public function search() {
        
        $db = Database::connect(); //Connect to database

        //Initialize variables
        $q = "";
        $posted = false;  //flag
        $results = array();

        //Check if form was submitted
        if (isset($_POST['q'])) {
            $posted = true;  //set the flag to true

            if (isset($_POST['q']) && $_POST['q']) { //q is posted and contains something
                
                $q = $_POST['q'];  //Store the search query
                
                $movie = new Movie($db); //Initialize the Movie class
                
                $movie->selectBasicSearch($q);
                if ($movie->errors) {
                    $errors = $movie->errors;
                    die(current($errors));
                } else {
                    $results = $movie->records;
                }
            } 
         }
        include_once('../views/movie/search.php');
        $db->close();
    }
        
        
    public function read(){
            $db = Database::connect(); //connect to database
            
            $results = array(); //Initialize variables
            
            $movie = new Movie($db);
            $movie->selectAll();
            if ($movie->errors) {
              //  $errors = $movie->errors;
                die(current($movie->errors));
            } else {
                $results = $movie->records;  //store records to results array for display
            }
        include_once('../views/movie/read.php');
        $db->close();
    }

}
