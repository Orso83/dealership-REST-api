<?php

class InventoryGateway {

    private $db = null;
    private $query = "SELECT * FROM inventory WHERE ";

    // Constructor.
    public function __construct($db) {
        $this->db = $db;
    }

    // Find vehicles by key value pair.
    public function findByCriteria($searchArray) {

        // Get the array's keys so we can iterate through the array with indexs.
        $keys = array_keys($searchArray);

        // If the array is empty, return all rows from the inventory.
        if(count($searchArray) == 0) {
            // Try to run the SQL query.
            try {
                $this->query = $this->db->query("SELECT * FROM inventory;");
                $result =  $this->query->fetchAll(\PDO::FETCH_ASSOC);
                return $result;
            } catch(\PDOException $e) {
                exit($e->getMessage());
            }
        // If the array contains key/value pairs, search based on provided key/values.
        } else {

            // Add the first search criteria to the query depending on operator.
            if($keys[0] == "yearFrom") {                // Year > x.
                $this->query .= " year >= \"" . $searchArray[$keys[0]] . "\"";
            } else if($keys[0] == "yearTo") {           // Year < x.
                $this->query .= " year <= \"" . $searchArray[$keys[0]] . "\"";
            } else if($keys[0] == "mileageFrom") {      // Mileage > x.
                $this->query .= " mileage >= \"" . $searchArray[$keys[0]] . "\"";
            } else if($keys[0] == "mileageTo") {        // Mileage < x.
                $this->query .= " mileage <= \"" . $searchArray[$keys[0]] . "\"";
            } else if($keys[0] == "priceFrom") {        // Price > x.
                $this->query .= " price >= \"" . $searchArray[$keys[0]] . "\"";
            } else if($keys[0] == "priceTo") {          // Price < x.
                $this->query .= " price <= \"" . $searchArray[$keys[0]] . "\"";
            } else {                            
                $this->query .= $keys[0] . " = \"" . $searchArray[$keys[0]] . "\"";
            }

            // For any additional search conditions add a "AND" and the criteria.
            for($i = 1; $i < count($searchArray); $i++) {
                if($keys[$i] == "yearFrom") {           // Year > x.
                    $this->query .= " AND year >= \"" . $searchArray[$keys[$i]] . "\"";
                } else if($keys[$i] == "yearTo") {      // Year < x.
                    $this->query .= " AND year <= \"" . $searchArray[$keys[$i]] . "\"";
                } else if($keys[$i] == "mileageFrom") { // Mileage > x.
                    $this->query .= " AND mileage >= \"" . $searchArray[$keys[$i]] . "\"";
                } else if($keys[$i] == "mileageTo") {   // Mileage < x.
                    $this->query .= " AND mileage <= \"" . $searchArray[$keys[$i]] . "\"";
                } else if($keys[$i] == "priceFrom") {   // Price > x.
                    $this->query .= " AND price >= \"" . $searchArray[$keys[$i]] . "\"";
                } else if($keys[$i] == "priceTo") {     // Price < x.
                    $this->query .= " AND price <= \"" . $searchArray[$keys[$i]] . "\"";
                } else {
                    $this->query .= " AND " . $keys[$i] . " = \"" . $searchArray[$keys[$i]] . "\"";
                }
            }

            // After the query has been built add a semicolon to the end.
            $this->query .= ";";

            // Try to run the SQL query.
            try {
                $this->query = $this->db->prepare($this->query);
                $this->query->execute();
                $result = $this->query->fetchAll(\PDO::FETCH_ASSOC);
    
                // Check if no results where returned.
                if($this->query->rowCount() == 0) {
                    $result = "Sorry, we did not find any matches.";
                }
    
                return $result;
            } catch(\PDOException $e) {
                exit($e->getMessage());
            }
        }

    }

    public function insertItem() {

        // Build the query.
        $this->query = "INSERT INTO inventory (make, model, year, color, mileage, type, price, transmission, drive) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";

        try {
            $this->query = $this->db->prepare($this->query);
            $this->query->execute(array($_POST['make'], $_POST['model'], $_POST['year'], $_POST['color'], $_POST['mileage'], $_POST['type'], $_POST['price'], $_POST['transmission'], $_POST['drive'],));

            // Check if any rows were added.
            if($this->query->rowCount() == 1) {
                return "The vehical has been added to the inventory.";
            } else {
                return "Sorry, we did not find any matches. No items where added.";
            }
            
        } catch(\PDOException $e) {
                exit($e->getMessage());
        }
    }

    public function removeItem() {

        // Build the query.
        $this->query = "DELETE FROM inventory WHERE id = ?;";

        try {
            $this->query = $this->db->prepare($this->query);
            $this->query->execute(array($_GET['id']));

            // Check if any rows where deleted.
            if($this->query->rowCount() == 1) {
                return "The vehical has been removed from the inventory.";
            } else {
                return "Sorry, we did not find any matches. No items where deleted.";
            }
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function updateItem($id, $searchArray) {

        // Get the array's keys so we can iterate through the array with indexs.
        $keys = array_keys($searchArray);

        // Build the base of the query.
        $this->query = "UPDATE inventory SET ";

        // Add the first update critiria to the query.
        $this->query .= $keys[0] . " = \"" . $searchArray[$keys[0]] . "\"";

        // If there are more than one update critiria, add them to the query.
        if(count($searchArray) > 0) {
            for($i = 1; $i < count($searchArray); $i++) {
                $this->query .= ", " . $keys[$i] . " = \"" . $searchArray[$keys[$i]] . "\"";
            }
        }

        // Add the 'id' to the WHERE condition of the query.
        $this->query .= " WHERE id = " . $id;

        // After the query has been built add a semicolon to the end.
        $this->query .= ";";
        echo $this->query;
        // Try to run the SQL query.
        try {
            $this->query = $this->db->prepare($this->query);
            $this->query->execute();
            return $result;
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }
}

?>