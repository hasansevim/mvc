<?php

class Inventory {

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

    public function selectAll() {
        $q = 'SELECT * FROM inventory';
        $this->db->process($q);
    }

    public function selectBasicSearch($search) {
        $q = sprintf('SELECT film.title, inventory.store_id, address.address, address.district, city.city,country.country,  address.phone, address.postal_code FROM inventory 
                    LEFT JOIN film ON inventory.film_id = film.film_id 
                    JOIN store ON inventory.store_id = store.store_id 
                    JOIN address ON store.address_id = address.address_id
                    JOIN city ON address.city_id = city.city_id
                    JOIN country ON city.country_id = country.country_id
                    GROUP BY inventory.inventory_id;
                    WHERE film.title LIKE "%s%%" OR address.address LIKE "%s%%" OR city.city LIKE "%s%%" OR address.district LIKE "%s%%" OR country.country LIKE "%s%%"', 
                $this->db->real_escape_string($search), 
                $this->db->real_escape_string($search), 
                $this->db->real_escape_string($search),
                $this->db->real_escape_string($search), 
                $this->db->real_escape_string($search),
                $this->db->real_escape_string($search),
                $this->db->real_escape_string($search),
                $this->db->real_escape_string($search));
        $this->process($q);
    }

    public function displayStoreInventory() {
        $q = 'SELECT title, COUNT(i.inventory_id) AS inventory_total, GROUP_CONCAT(i.inventory_id) AS inventory_id, CONCAT (address, "  ", city, "  ", country) as address FROM inventory AS i
                LEFT JOIN film_text ON i.film_id = film_text.film_id 
                LEFT JOIN store ON i.store_id = store.store_id 
                JOIN address ON store.address_id = address.address_id
                JOIN city ON address.city_id = city.city_id 
                JOIN country ON city.country_id = country.country_id 
                GROUP BY title';
        $this->process($q);
    }

    public function searchStoreInventory($search) {
        $q = sprintf('select title, COUNT(i.inventory_id) AS inventory_total, GROUP_CONCAT(i.inventory_id) AS inventory_id, CONCAT(address, "  ", city, "  ", country) as address FROM inventory AS i
                LEFT JOIN film_text ON i.film_id = film_text.film_id 
                LEFT JOIN store ON i.store_id = store.store_id 
                JOIN address ON store.address_id = address.address_id
                JOIN city ON address.city_id = city.city_id 
                JOIN country ON city.country_id = country.country_id
                WHERE title LIKE "%s%%" OR address LIKE "%s%%" 
                GROUP BY title', 
                $this->db->real_escape_string($search), 
                $this->db->real_escape_string($search), 
                $this->db->real_escape_string($search), 
                $this->db->real_escape_string($search));
        $this->process($q);
    }
    
    //create a new record
    public function insert ($film_id, $store_id) {
        $q = sprintf ('INSERT INTO inventory (SELECT film.film_id, store.store_id FROM film, store) VALUES ("%s", "%s")', 
                $this->db->real_escape_string($film_id), $this->db->real_escape_string($store_id));
        $this->process($q);
    }

    public function update($film_id, $store_id, $inventory_id) {
        $q = sprintf ("Update inventory SET film_id ='%s' , store_id = '%s' WHEE inventory_id ='%s'", 
                $this->db->real_escape_string($film_id), $this->db->real_escape_string($store_id), 
                $this->db->real_escape_string($inventory_id));
        $this->process($q);
    }
    
    public function delete($id) {
        $q = sprintf ("DELETE FROM inventory WHERE id ='%s'", $this->db->real_escape_string($id));
        $this->process($q);
    }
    
    
    private function process($q) {
        $r = $this->db->query($q);
        if ($this->db->errno) {
            $this->errors[] = 'MySQLi Error: ' . $this->db->error;
        } else {
            while ($row = $r->fetch_assoc()) {
                $this->records[] = $row;
            }
        }
    }
}
?>






