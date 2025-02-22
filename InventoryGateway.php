<?php
// Author: Christopher Orsolini

class InventoryGateway {

    private $db = null;
    private $query = "SELECT * FROM inventory WHERE ";
    private $keys = array();
    private $values = array();

    // Constructor.
    public function __construct($db) {
        $this->db = $db;
    }

    /**************************************************************************
    * Purpose: This function will make a SELECT DISTINCT on the makes.        *
    *          The result will be used to fill the html form select options   *
    *          for the select make dropdown in the UI.
    *                                                                         *
    * Inputs:  None.                                                          *
    *                                                                         *
    * Output:  An associative array of results, or an exception.              *
    **************************************************************************/
    public function findDistinctMake() {
        // Try to run the SQL query.
        try {
            $this->query = $this->db->query("SELECT DISTINCT make FROM inventory ORDER BY make;");
            $result =  $this->query->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**************************************************************************
    * Purpose: This function will make a SELECT DISTINCT on the colors.       *
    *          The result will be used to fill the html form select options   *
    *          for the select color dropdown in the UI.                       *
    *                                                                         *
    * Inputs:  None.                                                          *
    *                                                                         *
    * Output:  An associative array of results, or an exception.              *
    **************************************************************************/
    public function findDistinctColor() {
        // Try to run the SQL query.
        try {
            $this->query = $this->db->query("SELECT DISTINCT color FROM inventory ORDER BY color;");
            $result =  $this->query->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**************************************************************************
    * Purpose: This function will make a SELECT DISTINCT on the type.         *
    *          The result will be used to fill the html form select options   *
    *          for the select color dropdown in the UI.                       *
    *                                                                         *
    * Inputs:  None.                                                          *
    *                                                                         *
    * Output:  An associative array of results, or an exception.              *
    **************************************************************************/
    public function findDistinctType() {
        // Try to run the SQL query.
        try {
            $this->query = $this->db->query("SELECT DISTINCT type FROM inventory ORDER BY type;");
            $result =  $this->query->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**************************************************************************
    * Purpose: This function will make a SELECT DISTINCT on the transmission. *
    *          The result will be used to fill the html form select options   *
    *          for the select color dropdown in the UI.                       *
    *                                                                         *
    * Inputs:  None.                                                          *
    *                                                                         *
    * Output:  An associative array of results, or an exception.              *
    **************************************************************************/
    public function findDistinctTransmission() {
        // Try to run the SQL query.
        try {
            $this->query = $this->db->query("SELECT DISTINCT transmission FROM inventory ORDER BY transmission;");
            $result =  $this->query->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**************************************************************************
    * Purpose: This function will make a SELECT DISTINCT on the drivetrain.   *
    *          The result will be used to fill the html form select options   *
    *          for the select color dropdown in the UI.                       *
    *                                                                         *
    * Inputs:  None.                                                          *
    *                                                                         *
    * Output:  An associative array of results, or an exception.              *
    **************************************************************************/
    public function findDistinctDrivetrain() {
        // Try to run the SQL query.
        try {
            $this->query = $this->db->query("SELECT DISTINCT drive FROM inventory ORDER BY drive;");
            $result =  $this->query->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**************************************************************************
    * Purpose: This function handles all SELECT querys. The defualt behavior  *
    *          is to SELECT all items from the inventory table. If an array   *
    *          is passed in, the query will search based on the provided      *
    *          conditions. If there is more than one search critiria, the     *
    *          query will add and AND for each additonal WHERE condition. The *
    *          query is created using the PDO prepare statement.              *
    *                                                                         *
    * Inputs:  An associative array. Keys = column name. Values = condition.  *
    *                                                                         *
    * Output:  An associative array of results, or an exception.              *
    **************************************************************************/
    public function findByCriteria($searchArray) {

        // Get the array's keys so we can iterate through the array with indexs.
        $this->keys = array_keys($searchArray);

        // Fill an array with values from the key/value pairs to use with PDO prepare.
        for($i = 0; $i < count($searchArray); $i++) {
            $this->values[] = $searchArray[$this->keys[$i]];
        }

        // If the array is empty, return all rows from the inventory.
        if(count($searchArray) == 0) {

            // If there is ORDER BY critiria.
            if(isset($_GET['orderByMake'])) {
                if($_GET['orderByMake'] == 0){
                    // Build the query.
                    $this->query = "SELECT * FROM inventory ORDER BY make ASC;";
                } else if ($_GET['orderByMake'] == 1) {
                    // Build the query.
                    $this->query = "SELECT * FROM inventory ORDER BY make DESC;";
                }
            } else if (isset($_GET['orderByModel'])) {
                if($_GET['orderByModel'] == 0){
                    // Build the query.
                    $this->query = "SELECT * FROM inventory ORDER BY model ASC;";
                } else if ($_GET['orderByModel'] == 1) {
                    // Build the query.
                    $this->query = "SELECT * FROM inventory ORDER BY model DESC;";
                }
            } else if (isset($_GET['orderByYear'])) {
                if($_GET['orderByYear'] == 0){
                    // Build the query.
                    $this->query = "SELECT * FROM inventory ORDER BY year ASC;";
                } else if ($_GET['orderByYear'] == 1) {
                    // Build the query.
                    $this->query = "SELECT * FROM inventory ORDER BY year DESC;";
                }
            } else if (isset($_GET['orderByColor'])) {
                if($_GET['orderByColor'] == 0){
                    // Build the query.
                    $this->query = "SELECT * FROM inventory ORDER BY color ASC;";
                } else if ($_GET['orderByColor'] == 1) {
                    // Build the query.
                    $this->query = "SELECT * FROM inventory ORDER BY color DESC;";
                }
            } else if (isset($_GET['orderByMileage'])) {
                if($_GET['orderByMileage'] == 0){
                    // Build the query.
                    $this->query = "SELECT * FROM inventory ORDER BY mileage ASC;";
                } else if ($_GET['orderByMileage'] == 1) {
                    // Build the query.
                    $this->query = "SELECT * FROM inventory ORDER BY mileage DESC;";
                }
            } else if (isset($_GET['orderByType'])) {
                if($_GET['orderByType'] == 0){
                    // Build the query.
                    $this->query = "SELECT * FROM inventory ORDER BY type ASC;";
                } else if ($_GET['orderByType'] == 1) {
                    // Build the query.
                    $this->query = "SELECT * FROM inventory ORDER BY type DESC;";
                }
            } else if (isset($_GET['orderByPrice'])) {
                if($_GET['orderByPrice'] == 0){
                    // Build the query.
                    $this->query = "SELECT * FROM inventory ORDER BY price ASC;";
                } else if ($_GET['orderByPrice'] == 1) {
                    // Build the query.
                    $this->query = "SELECT * FROM inventory ORDER BY price DESC;";
                }
            } else if (isset($_GET['orderByTransmission'])) {
                if($_GET['orderByTransmission'] == 0){
                    // Build the query.
                    $this->query = "SELECT * FROM inventory ORDER BY transmission ASC;";
                } else if ($_GET['orderByTransmission'] == 1) {
                    // Build the query.
                    $this->query = "SELECT * FROM inventory ORDER BY transmission DESC;";
                }
            } else if (isset($_GET['orderByDrive'])) {
                if($_GET['orderByDrive'] == 0){
                    // Build the query.
                    $this->query = "SELECT * FROM inventory ORDER BY drive ASC;";
                } else if ($_GET['orderByDrive'] == 1) {
                    // Build the query.
                    $this->query = "SELECT * FROM inventory ORDER BY drive DESC;";
                }
            } else {    // If no ORDER BY criteria is set.
                $this->query = "SELECT * FROM inventory;";
            }

            // Try to run the SQL query.
            try {
                $this->query = $this->db->query($this->query);
                $result =  $this->query->fetchAll(\PDO::FETCH_ASSOC);
                return $result;
            } catch(\PDOException $e) {
                exit($e->getMessage());
            }

            
        // If the array contains key/value pairs, search based on provided key/values.
        } else {

            // Add the first search criteria to the query depending on operator.
            if($this->keys[0] == "yearFrom") {                // Year > x.
                $this->query .= " year >= ?";
            } else if($this->keys[0] == "yearTo") {           // Year < x.
                $this->query .= " year <= ?";
            } else if($this->keys[0] == "mileageFrom") {      // Mileage > x.
                $this->query .= " mileage >= ?";
            } else if($this->keys[0] == "mileageTo") {        // Mileage < x.
                $this->query .= " mileage <= ?";
            } else if($this->keys[0] == "priceFrom") {        // Price > x.
                $this->query .= " price >= ?";
            } else if($this->keys[0] == "priceTo") {          // Price < x.
                $this->query .= " price <= ?";
            } else {                            
                $this->query .= $this->keys[0] . " = ?";
            }

            // For any additional search conditions add an "AND" to the criteria.
            for($i = 1; $i < count($searchArray); $i++) {
                if($this->keys[$i] == "yearFrom") {           // Year > x.
                    $this->query .= " AND year >= ?";
                } else if($this->keys[$i] == "yearTo") {      // Year < x.
                    $this->query .= " AND year <= ?";
                } else if($this->keys[$i] == "mileageFrom") { // Mileage > x.
                    $this->query .= " AND mileage >= ?";
                } else if($this->keys[$i] == "mileageTo") {   // Mileage < x.
                    $this->query .= " AND mileage <= ?";
                } else if($this->keys[$i] == "priceFrom") {   // Price > x.
                    $this->query .= " AND price >= ?";
                } else if($this->keys[$i] == "priceTo") {     // Price < x.
                    $this->query .= " AND price <= ?";
                } else {
                    $this->query .= " AND " . $this->keys[$i] . " = ?";
                }
            }

            // If there is ORDER BY critiria.
            if(isset($_GET['orderByMake'])) {
                if($_GET['orderByMake'] == 0){
                    // Build the query.
                    $this->query .= " ORDER BY make ASC;";
                } else if ($_GET['orderByMake'] == 1) {
                    // Build the query.
                    $this->query .= " ORDER BY make DESC;";
                }
            } else if (isset($_GET['orderByModel'])) {
                if($_GET['orderByModel'] == 0){
                    // Build the query.
                    $this->query .= " ORDER BY model ASC;";
                } else if ($_GET['orderByModel'] == 1) {
                    // Build the query.
                    $this->query .= " ORDER BY model DESC;";
                }
            } else if (isset($_GET['orderByYear'])) {
                if($_GET['orderByYear'] == 0){
                    // Build the query.
                    $this->query .= " ORDER BY year ASC;";
                } else if ($_GET['orderByYear'] == 1) {
                    // Build the query.
                    $this->query .= " ORDER BY year DESC;";
                }
            } else if (isset($_GET['orderByColor'])) {
                if($_GET['orderByColor'] == 0){
                    // Build the query.
                    $this->query .= " ORDER BY color ASC;";
                } else if ($_GET['orderByColor'] == 1) {
                    // Build the query.
                    $this->query .= " ORDER BY color DESC;";
                }
            } else if (isset($_GET['orderByMileage'])) {
                if($_GET['orderByMileage'] == 0){
                    // Build the query.
                    $this->query .= " ORDER BY mileage ASC;";
                } else if ($_GET['orderByMileage'] == 1) {
                    // Build the query.
                    $this->query .= " ORDER BY mileage DESC;";
                }
            } else if (isset($_GET['orderByType'])) {
                if($_GET['orderByType'] == 0){
                    // Build the query.
                    $this->query .= " ORDER BY type ASC;";
                } else if ($_GET['orderByType'] == 1) {
                    // Build the query.
                    $this->query .= " ORDER BY type DESC;";
                }
            } else if (isset($_GET['orderByPrice'])) {
                if($_GET['orderByPrice'] == 0){
                    // Build the query.
                    $this->query .= " ORDER BY price ASC;";
                } else if ($_GET['orderByPrice'] == 1) {
                    // Build the query.
                    $this->query .= " ORDER BY price DESC;";
                }
            } else if (isset($_GET['orderByTransmission'])) {
                if($_GET['orderByTransmission'] == 0){
                    // Build the query.
                    $this->query .= " ORDER BY transmission ASC;";
                } else if ($_GET['orderByTransmission'] == 1) {
                    // Build the query.
                    $this->query .= " ORDER BY transmission DESC;";
                }
            } else if (isset($_GET['orderByDrive'])) {
                if($_GET['orderByDrive'] == 0){
                    // Build the query.
                    $this->query .= " ORDER BY drive ASC;";
                } else if ($_GET['orderByDrive'] == 1) {
                    // Build the query.
                    $this->query .= " ORDER BY drive DESC;";
                }
            }

            // After the query has been built add a semicolon to the end.
            $this->query .= ";";

            // Try to run the SQL query.
            try {
                $this->query = $this->db->prepare($this->query);
                $this->query->execute($this->values);
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

    /**************************************************************************
    * Purpose: This function handles all INSERT querys. It takes values from  *
    *          $_POST and appends them to the query with the PDO prepare      *
    *          statement.                                                     *
    *                                                                         *
    * Inputs:  None.                                                          *
    *                                                                         *
    * Output:  An success message, fail message, or an exception.             *
    **************************************************************************/
    public function insertItem() {

        // Build the query.
        $this->query = "INSERT INTO inventory (make, model, year, color, mileage, type, price, transmission, drive) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";

        try {
            $this->query = $this->db->prepare($this->query);
            $this->query->execute(array($_POST['make'], $_POST['model'], $_POST['year'], $_POST['color'], $_POST['mileage'], $_POST['type'], $_POST['price'], $_POST['transmission'], $_POST['drive'],));

            // Check if any rows were added.
            if($this->query->rowCount() == 1) {
                return "The vehicle has been added to the inventory.";
            } else {
                return "Sorry, we did not find any matches. No items where added.";
            }
            
        } catch(\PDOException $e) {
                exit($e->getMessage());
        }
    }

    /**************************************************************************
    * Purpose: This function handles all DELETE querys. A id is passed in for *
    *          the item that is to be deleted. The id is appended with the    *
    *          PDO prepare statment.                                          *
    *                                                                         *
    * Inputs:  Id for the item that has been selected for deletion.           *
    *                                                                         *
    * Output:  An success message, fail message, or an exception.             *
    **************************************************************************/
    public function removeItem($id) {

        // Build the query.
        $this->query = "DELETE FROM inventory WHERE id = ?;";

        try {
            $this->query = $this->db->prepare($this->query);
            $this->query->execute(array($id));

            // Check if any rows where deleted.
            if($this->query->rowCount() == 1) {
                return "The vehicle has been removed from the inventory.";
            } else {
                return "Sorry, we did not find any matches. No items where deleted.";
            }
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**************************************************************************
    * Purpose: This function handles all UPDATE querys. An id for the item    *
    *          that is to be updated is passed in. An associative array is    *
    *          also passed in. The query will search based on the provided    *
    *          conditions. If there is more than one search critiria, the     *
    *          query will add and "," for each additonal SET condition.       *
    *          The query is created using the PDO prepare statement.          *
    *                                                                         *
    * Inputs:  Id for the item that has been selected for deletion.           *
    *          Associative array with key/value pairs for update conditions.  *
    *          Keys = column name. Values = condition.                        *
    *                                                                         *
    * Output:  An exception.                                                  *
    **************************************************************************/
    public function updateItem($id, $searchArray) {

        // Get the array's keys so we can iterate through the array with indexs.
        $this->keys = array_keys($searchArray);

        // Fill an array with values from the key/value pairs to use with PDO prepare.
        for($i = 0; $i < count($searchArray); $i++) {
            $this->values[] = $searchArray[$this->keys[$i]];
        }

        // Build the base of the query.
        $this->query = "UPDATE inventory SET ";

        // Add the first update critiria to the query.
        $this->query .= $this->keys[0] . " = ?";

        // If there are more than one update critiria, add them to the query.
        if(count($searchArray) > 0) {
            for($i = 1; $i < count($searchArray); $i++) {
                $this->query .= ", " . $this->keys[$i] . " = ?";
            }
        }

        // Add the 'id' to the WHERE condition of the query.
        $this->query .= " WHERE id = " . $id;

        // After the query has been built add a semicolon to the end.
        $this->query .= ";";

        // Try to run the SQL query.
        try {
            $this->query = $this->db->prepare($this->query);
            $this->query->execute($this->values);
            
            // Check if any rows where deleted.
            if($this->query->rowCount() == 1) {
                return "The vehicle has been updated in the inventory.";
            } else {
                return "Sorry, we did not find any matches. No items where updated.";
            }
        } catch(\PDOException $e) {
            exit($e->getMessage());
        }
    }
}

?>