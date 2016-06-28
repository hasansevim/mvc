<?php

class Actor {

    private $db = null;
    private $errors = array();
    private $records = array();

    public function __construct($db) {
        $this->db = $db;
    }

    public function __get($prop) {
        if (property_exists($this, $prop)) {
            return $this->$prop;
        } else {
            return null;
        }
    }
   //For read
    public function selectAll() {
        $q = 'SELECT * FROM actor';
        $this->process($q);
    }

    //For search
    public function selectBasicSearch($search) {
        $q = sprintf('SELECT * FROM actor WHERE first_name LIKE "%s%%" OR last_name LIKE "%s%%"', $this->db->real_escape_string($search), $this->db->real_escape_string($search));
        $this->process($q);
    }

    public function selectAdvancedSearch($search) {
        $q = sprintf('SELECT actor.first_name, actor.last_name, GROUP_CONCAT(film.title) AS "films" FROM actor  
                LEFT JOIN film_actor ON actor.actor_id = film_actor.actor_id
                LEFT JOIN film ON film_actor.film_id = film.film_id
                WHERE first_name LIKE "%s%%" OR last_name LIKE "%s%%" OR title LIKE "%s%%"
                GROUP BY actor.actor_id ORDER BY actor.last_name', $this->db->real_escape_string($search), $this->db->real_escape_string($search), $this->db->real_escape_string($search));
        $this->process($q);
    }

    //Create a new record
    public function insert($first_name, $last_name) {
        $q = sprintf("INSERT INTO actor (first_name, last_name) VALUES ('%s', '%s')", 
                $this->db->real_escape_string($first_name), $this->db->real_escape_string($last_name));
        $this->process($q);
    }

    //Update a record
    public function update($first_name, $last_name, $id) {
        $q = sprintf("Update actor SET first_name ='%s', last_name = '%s' WHERE actor.id ='%s'", $this->db->real_escape_string($first_name), $this->db->real_escape_string($last_name), is_numeric($this->db->real_escape_string($id)));
        $this->process($q);
    }

    //Delete a record
    public function delete($id) {
        $q = sprintf("DELETE FROM actor WHERE actor_id='%s'" . is_numeric($this->db->real_escape_string($id)));
        $this->process($q);
    }

    //Process a query
    private function process($q) {
        $r = $this->db->query($q);
        if ($this->db->errno) {
            $this->errors[] = 'MySQLi Error: ' . $this->db->error;
        } else {
            while ($row = $r->fetch_assoc()) {
                $this->records[] = $row;  //Go through each row and store the data in records array
            }
        }
    }

}
