<?php
require './InventoryGateway.php';

class InventoryController {

    private $db;
    private $requestMethod;
    private $inventoryGateway;

    private $searchArray = array();
    private $make;
    private $transmission;

    // Constructor.
    public function __construct($db, $requestMethod) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;

        $this->inventoryGateway = new InventoryGateway($db);
    }

    // Proccess the http request method.
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
                echo "Successful PUT request to the Controller.";
                break;
            case 'DELETE':
                $this->deleteRequest();
                break;
            default:
                echo "HTTP request not Found.";
                break;
        }
    }

    private function getRequest($searchArray) {
        $result = $this->inventoryGateway->findByCriteria($searchArray);
        $result = json_encode($result);
        $data = json_decode($result);
        print_r($result);
    }

    private function postRequest() {
        $result = $this->inventoryGateway->insertItem();
        // $result = json_encode($result);
        // $data = json_decode($result);
        print_r($result);
    }

    private function deleteRequest() {
        $result = $this->inventoryGateway->removeItem();
        // $result = json_encode($result);
        // $data = json_decode($result);
        print_r($result);
    }
}

?>
