<?php
/**
 * Author: seef
 * Date: 05-04-20
 * Time: 00:46
 */
header('Content-Type: application/json');


require __DIR__ . '/../vendor/autoload.php';
use \httprequest\RequestProcessor;
use \httprequest\ResourceFactory;
use \httprequest\TestClass;

$resourceFactory = new ResourceFactory();
$requestProcessor = new RequestProcessor();
//echo json_encode(filter_input_array(INPUT_SERVER), JSON_PRETTY_PRINT);
//echo json_encode($requestProcessor->getCurrentRequestHeaders(), JSON_PRETTY_PRINT);
//echo json_encode($requestProcessor->getRequestURI(), JSON_PRETTY_PRINT);
//echo json_encode($_SERVER['REQUEST_URI'], JSON_PRETTY_PRINT);
//echo 'request uri is: ' . var_dump($_SERVER['REQUEST_URI']);
//var_dump($requestProcessor->getHost());

try {
    echo json_encode($requestProcessor->getUri(), JSON_PRETTY_PRINT);
} catch (Exception $ex) {
    echo $ex->getMessage();
}
//echo json_encode($requestProcessor->getResourceId(), JSON_PRETTY_PRINT);

switch($requestProcessor->getRequestType()) {
    case RequestProcessor::POST:    // Create a new resource

        // Use the create method
        break;
    case RequestProcessor::GET:     // Retrieve a resource
        // Use the find method
        try {
            $class = '\httprequest\\' .  $requestProcessor->getResourceName()  . "Class";
            /** @var TestClass $type */
            $type = new $class('mijntest');
//            echo $type->getName();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }

        break;

    case RequestProcessor::PUT:     // Update a resource
        // Use the update method
        break;

    case RequestProcessor::DELETE:  // Delete a resource
        // Use the delete method
        break;

    case RequestProcessor::OPTIONS:
        break;

    case RequestProcessor::HEAD:
        break;

    case RequestProcessor::TRACE:
        break;

    case RequestProcessor::PATCH:
        break;

    case RequestProcessor::CONNECT:
        break;
}


?>
