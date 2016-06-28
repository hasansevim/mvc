<?php

class Rental {

	private $db = null;
	private $errors = array();
	private $records = array();
        
	public function __construct($db) {
		$this->db = $db;
	}

	public function __get($prop) {
		if (property_exists($this, $prop)){
			return $this->$prop;
                }else{
			return null;
                }
	}

	public function selectAll() {
		$q = 'SELECT * FROM rental';
		$this->process($q);
	}
        
        public function selectBasicSearch($search) {
            $q = sprintf('SELECT rental_date, film.title, CONCAT(customer.first_name, ", ", customer.last_name) AS customer, return_date, CONCAT(staff.first_name, ", ", staff.last_name) AS staff
                    FROM rental LEFT JOIN inventory on rental.inventory_id = inventory.inventory_id
                    JOIN film ON inventory.film_id = film.film_id
                    JOIN customer ON rental.customer_id = customer.customer_id 
                    JOIN staff ON rental.staff_id = staff.staff_id
                    GROUP BY rental_date',
                    $this->db->real_escape_string($search),
                    $this->db->real_escape_string($search),
                    $this->db->real_escape_string($search),
                    $this->db->real_escape_string($search),
                    $this->db->real_escape_string($search));
             $this->process($q); 
        }
        
        public function selectAllCustomerRentals() {
            $q = 'SELECT customer.first_name, customer.last_name, film.title as title, rental_date, return_date
                FROM rental LEFT JOIN customer ON rental.customer_id = customer.customer_id
                JOIN staff ON rental.staff_id = staff.staff_id
                JOIN inventory ON rental.inventory_id = inventory.inventory_id 
                JOIN film ON inventory.film_id = film.film_id
                GROUP BY customer.customer_id ORDER BY customer.last_name';
            $this->process($q);
        }

        public function searchCustomerRentals($search) {
            $q = sprintf('SELECT customer.first_name, customer.last_name, title, rental_date, return_date
                FROM rental LEFT JOIN customer ON rental.customer_id = customer.customer_id
                JOIN staff ON rental.staff_id = staff.staff_id
                JOIN inventory ON rental.inventory_id = inventory.inventory_id 
                JOIN film ON inventory.film_id = film.film_id
                WHERE customer.first_name LIKE "%s%%" OR customer.last_name LIKE "%s%%" OR title LIKE "%s%%"
                GROUP BY customer.customer_id ORDER BY customer.last_name',
                $this->db->real_escape_string($search), 
                $this->db->real_escape_string($search), 
                $this->db->real_escape_string($search),
                $this->db->real_escape_string($search), 
                $this->db->real_escape_string($search));
            $this->process($q);
        }
        
        public function searchFilmRentals($search) {
            $q = sprintf('SELECT i.inventory_id, COUNT(r.rental_id) AS num_rentals, title  
                        FROM inventory as i 
                        LEFT JOIN rental as r ON i.inventory_id = r.inventory_id 
                        JOIN film ON i.film_id = film.film_id
                        WHERE title LIKE "%s%%"
                        GROUP BY i.inventory_id ORDER BY num_rentals ASC', 
                        $this->db->real_escape_string($search), 
                        $this->db->real_escape_string($search), 
                        $this->db->real_escape_string($search));
            $this->process($search);
        }
        
        public function insert($rental_date, $inventory_id, $customer_id, $return_date, $stuff_id) {
           $q = sprintf ("INSERT INTO rental (rental_date, inventoray_id, customer_id, return_date, stuff_id) VALUES ('%s', '%s', '%s', '%s', '%s')", 
                    $this->db->real_escape_string($rental_date), $this->db->real_escape_string($inventory_id),
                    $this->db->real_escape_string($customer_id), $this->db->real_escape_string($return_date),
                    $this->db->real_escape_string($stuff_id));
           $this->process($q);
        }
        
        
        public function update($rental_date, $inventory_id, $customer_id, $return_date, $stuff_id, $rental_id) {
           $q = spintf("Update renta SET rental_date ='%s', inventory_id='%s', customer_id='%s', return_date='%s', stuff_id='%s' WHERE rental_id= '%s'",
                $this->db->real_escape_string($rental_date), $this->db->real_escape($inventory_id), $this->db->real_escape_string($customer_id), 
                $this->db->real_escape_string($return_date), $this->db->real_escape_string($stuff_id), $this->db->real_escape_string($rental_id));
           $this->process($q);
        }
        
        
        public function delete($id){
            $q = sprintf("DELETE FROM rental WHERE rental_id ='%s'", $this->db->real_escape_string($id));
            $this->process($q);
        }
        
	private function process($q) {
		$r = $this->db->query($q);
		if ($this->db->errno) {
			$this->errors[] = 'MySQLi Error: '.$this->db->error;
		} else {
			while ($row = $r->fetch_assoc()){
				$this->records[] = $row;
                        }
		}
	}
}

?>

