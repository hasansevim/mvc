<?php

class Customer {
    private $db = null;
    private $errors = array ();
    private $records = array ();
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function __get($prop) {
        if(property_exists ($this, $prop)) {
            return $this->$prop;
        } else {
            return null;
        }
    }
    
    public function selectAll() {
        $q = 'SELECT * FROM customer';
        $this->process($q);
    }
    
    public function displayAll() {
       $q = 'SELECT customer.first_name, customer.last_name, email, CONCAT(address, ",  ", city,",  ", country, "   ", postal_code) AS contact FROM customer 
            LEFT JOIN address ON customer.address_id = address.address_id 
            JOIN city on address.city_id = city.city_id 
            JOIN country on city.country_id = country.country_id';
       $this->process($q);
    }
    
    //real_escape_string escape special characters for use in SQL statement
    public function selectBasicSearch($search) {
        $q = sprintf('SELECT customer.first_name, customer.last_name, '
                . 'email, CONCAT(address, ", ", city, ", ", country, " ", postal_code) AS contact '
                . 'FROM customer '
                . 'LEFT JOIN address ON customer.address_id = address.address_id '
                . 'JOIN city on address.city_id = city.city_id '
                . 'JOIN country on city.country_id = country.country_id WHERE first_name LIKE "%s%%" OR last_name LIKE "%s%%" OR email LIKE "%s%%"', 
                    $this->db->real_escape_string($search), 
                    $this->db->real_escape_string($search), 
                    $this->db->real_escape_string($search),
                    $this->db->real_escape_string($search)  
                );
       
        $this->process($q);
    }
    
    public function insert($first_name, $last_name, $email) {
        $q = sprintf("INSERT INTO customer (first_name, last_name, email) VALUES ('%s', '%s', '%s)",
                    $this->db->real_esacpe_string($first_name), 
                    $this->db->real_escape_string($last_name), 
                    $this->db->real_escape_string($email));
                   
        $this->process($q);
    }
    
   
    public function update($first_name, $last_name, $email, $id) {
        $q = sprintf ('Update customer SET first_name = "%s", last_name ="%s", email = "%s" WHERE customer_id ='.$this->db->real_escape_string($id),
                $this->db->real_escape_string($first_name), $this->db->real_escape_string($last_name, $this->db->real_escape_string($email)));
        $this->process($q);        
    }
    
     public function delete($id) {
        $q = sprintf ('DELETE FROM actor WHERE customer_id =' . $this->db->real_escape_string($id));
        $this->process($q);
    }
    
    
    private function process($q) {
        $r = $this->db->query($q);
        if($this->db->errno) {
            $this->errors[] = 'MySQLi Error: '.$this->db->error;
        } else {
            while ($row = $r->fetch_assoc()) {
                $this->records[] = $row;
            }
        }
    }
}

