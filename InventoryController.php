<?php
// Author: Christopher Orsolini

require './InventoryGateway.php';

class InventoryController {

    private $db;
    private $requestMethod;
    private $inventoryGateway;

    private $searchArray = array();
    private $id;

    // Constructor.
    public function __construct($db, $requestMethod) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;

        $this->inventoryGateway = new InventoryGateway($db);
    }

    /**************************************************************************
    * Purpose: This function handles all http request methods and calls the   *
    *          appropriate handling function.                                 *
    *                                                                         *
    * Inputs:  None.                                                          *
    *                                                                         *
    * Output:  An message if the https request method is not accepted.        *
    **************************************************************************/
    public function processRequest() {

        switch ($this->requestMethod) {
            case 'GET':
                // Check the URL for GET criteria and add them to the array of search critira.
                if(isset($_GET['make'])) {
                    $searchArray['make'] = $_GET['make'];
                }
                if(isset($_GET['model'])) {
                    $searchArray['model'] = $_GET['model'];
                }
                if(isset($_GET['year'])) {
                    $searchArray['year'] = $_GET['year'];
                }
                if(isset($_GET['yearFrom'])) {
                    $searchArray['yearFrom'] = $_GET['yearFrom'];
                }
                if(isset($_GET['yearTo'])) {
                    $searchArray['yearTo'] = $_GET['yearTo'];
                }
                if(isset($_GET['color'])) {
                    $searchArray['color'] = $_GET['color'];
                }
                if(isset($_GET['mileage'])) {
                    $searchArray['mileage'] = $_GET['mileage'];
                }
                if(isset($_GET['mileageFrom'])) {
                    $searchArray['mileageFrom'] = $_GET['mileageFrom'];
                }
                if(isset($_GET['mileageTo'])) {
                    $searchArray['mileageTo'] = $_GET['mileageTo'];
                }
                if(isset($_GET['type'])) {
                    $searchArray['type'] = $_GET['type'];
                }
                if(isset($_GET['price'])) {
                    $searchArray['price'] = $_GET['price'];
                }
                if(isset($_GET['priceFrom'])) {
                    $searchArray['priceFrom'] = $_GET['priceFrom'];
                }
                if(isset($_GET['priceTo'])) {
                    $searchArray['priceTo'] = $_GET['priceTo'];
                }
                if(isset($_GET['transmission'])) {
                    $searchArray['transmission'] = $_GET['transmission'];
                }
                if(isset($_GET['drive'])) {
                    $searchArray['drive'] = $_GET['drive'];
                }
                // Once the search array is built, send it to the getRequest() function.
                $this->getRequest($searchArray);
                break;
            case 'POST':
                $this->postRequest();
                break;
            case 'PUT':
                // Get the 'id' for the item that will be updated.
                $this->id = $_GET['id'];

                // Check the URL for GET criteria and add them to the array of search critira.
                if(isset($_GET['make'])) {
                    $searchArray['make'] = $_GET['make'];
                }
                if(isset($_GET['model'])) {
                    $searchArray['model'] = $_GET['model'];
                }
                if(isset($_GET['year'])) {
                    $searchArray['year'] = $_GET['year'];
                }
                if(isset($_GET['color'])) {
                    $searchArray['color'] = $_GET['color'];
                }
                if(isset($_GET['mileage'])) {
                    $searchArray['mileage'] = $_GET['mileage'];
                }
                if(isset($_GET['type'])) {
                    $searchArray['type'] = $_GET['type'];
                }
                if(isset($_GET['price'])) {
                    $searchArray['price'] = $_GET['price'];
                }
                if(isset($_GET['transmission'])) {
                    $searchArray['transmission'] = $_GET['transmission'];
                }
                if(isset($_GET['drive'])) {
                    $searchArray['drive'] = $_GET['drive'];
                }

                $this->updateRequest($this->id, $searchArray);
                break;
            case 'DELETE':
                $this->id = $_GET['id'];
                $this->deleteRequest($this->id);
                break;
            default:
                echo "HTTP request not Found.";
                break;
        }
    }

    /**************************************************************************
    * Purpose: This function handles any GET http request by calling the      *
    *          appropriate function from the gateway.                         *
    *                                                                         *
    * Inputs:  An assocative array containing the search critiria.            *
    *                                                                         *
    * Output:  JSON containing the returned results.                          *
    **************************************************************************/
    private function getRequest($searchArray) {
        $result = $this->inventoryGateway->findByCriteria($searchArray);
        $result = json_encode($result);
        $data = json_decode($result);
        print_r($result);
    }

    /**************************************************************************
    * Purpose: This function handles any POST http request by calling the     *
    *          appropriate function from the gateway.                         *
    *                                                                         *
    * Inputs:  None.                                                          *
    *                                                                         *
    * Output:  JSON containing the returned results.                          *
    **************************************************************************/
    private function postRequest() {
        $result = $this->inventoryGateway->insertItem();
        $result = json_encode($result);
        $data = json_decode($result);
        print_r($result);
    }

    /**************************************************************************
    * Purpose: This function handles any DELETE http request by calling the   *
    *          appropriate function from the gateway.                         *
    *                                                                         *
    * Inputs:  A id for the item that will be deleted.                        *
    *                                                                         *
    * Output:  JSON containing any message from the result.                   *
    **************************************************************************/
    private function deleteRequest($id) {
        $result = $this->inventoryGateway->removeItem($id);
        $result = json_encode($result);
        $data = json_decode($result);
        print_r($result);
    }

    /**************************************************************************
    * Purpose: This function handles any PUT http request by calling the      *
    *          appropriate function from the gateway.                         *
    *                                                                         *
    * Inputs:  The id for the item that will be updated.                      *
    *          An assocative array containing the search critiria.            *
    *                                                                         *
    * Output:  JSON containing any message from the result.                   *
    **************************************************************************/
    private function updateRequest($id, $searchArray) {
        $result = $this->inventoryGateway->updateItem($id, $searchArray);
        $result = json_encode($result);
        $data = json_decode($result);
        print_r($result);
    }
}

?>
