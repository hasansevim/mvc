<?php

class Movie {
    private $db = null;
    private $errors = array();
    private $records = array();
    
    public function __construct($db) {
       $this->db = $db; 
}

  public function __get($prop) {
      if(property_exists($this, $prop)) {
          return $this->$prop ;
      } else {
          return null;
      }
    }
    
    public function selectAll() {
        $q = 'SELECT * FROM film';
        $this->process($q);
    }
  
    public function selectBasic($search) {
        $q = sprintf('SELECT title, description FROM film WHERE title LIKE "%s%%" OR description LIKE "%s%%"',
        $this->db->real_escape_string($search), $this->db->real_escape_string($search));
        $this->process($q);
    }
    
    public function selectBasicSearch($search) {
        $q = sprintf('SELECT * FROM film WHERE title LIKE "%s%%" OR description LIKE "%s%%" OR special_features LIKE "%s%%"', 
                $this->db->real_escape_string($search), $this->db->real_escape_string($search), $this->db->real_escape_string($search));
       $this->process($q);
    }
    
    public function displaySalesByFilmCategory() {
        $q = 'SELECT c.name, sum(payment.amount) AS total FROM category as c LEFT JOIN film_category as fc ON c.category_id = fc.category_id
            JOIN inventory ON fc.film_id = inventory.film_id
            JOIN rental ON inventory.inventory_id = rental.inventory_id
            JOIN payment ON rental.rental_id = payment.rental_id
            GROUP BY c.category_id ORDER BY total DESC';
        $this->process($q);
    }
    
    public function insert($title, $description, $release_year, $language_id, $original_language_id, $rental_duration, $rental_rate, $length, $replacement_cost, $rating, $special_features) {
        $q = sprintf("INSERT INTO film (title, description, release_year, language_id, original_language_id, rental_duration, rental_rate, length, replacement_cost, rating, special_features) VALUES ('$s','$s', '$s', 'language.language_id', 'language.original_language_id', '$s', '$s', '$s', '$s', '$s', '$s')",
                $this->db->real_escape_string($title), $this->db->real_escape_string($description), $this->db->real_escape_string($release_year), $this->db->real_escape_string($language_id), $this->db->real_escape_string($original_language_id), 
                $this->db->real_escape_string($rental_duration), $this->db->real_escape_string($rental_length), $this->db->real_escape_string($length), $this->db->real_escape_string($replacement_cost), 
                $this->db->real_escape_string($rating), $this->db->real_escape_string($special_features));
       $this->process($q); 
    }
    
    public function update($title, $description, $release_year, $language_id, $original_language_id, $rental_duration, $rental_rate, $length, $replacement_cost, $rating, $special_features) {
        $q = sprintf("Update film SET title ='%s', description='%s', release_year='%s', language_id='%s', original_language_id='%s', rental_duration='%s', rental_rate='%s', length='%s', replacement_cost='%s', rating='%s', special_features='%s' WHERE film_id= ".$id,
                $this->db->real_escape_string($title), $this->db->real_escape($description), $this->db->real_escape_string($release_year), 
                $this->db->real_escape_string($language_id), $this->db->real_escape_string($original_language_id), $this->db->real_escape_string($rental_duration),
                $this->db->real_escape_string($rental_rate), $this->db->real_escape_string($length), $this->db->real_escape_string($replacement_cost),
                $this->db->real_escape_string($rating), $this->db->real_escape_string($special_features));
        $this->process($q);
    }
    
    public function delete($id) {
        $q = sprintf("DELETE FROM film WHERE film_id =". $this->db->real_escape_string($id));
        $this->process($q);
    }
    
    private function process($q) {
        $r = $this->db->query($q);
        if ($this->db->errno) {
            $this->errors[] = 'MySQLi Error: '.$this->db->error;
        } else {
               while ($row = $r->fetch_assoc()) {
                       $this->records[] = $row;
            }
        }
    }
}
?>
