<?php
/**
 * Created by PhpStorm.
 * Author: seef
 * Date: 03-04-20
 * Time: 12:32
 */

class RequestProcessor {
    private $requestType;

    public function __construct() {}

    public function getRequestType() : string {
        $this->requestType = filter_input(INPUT_SERVER, "REQUEST_METHOD");
        switch ($this->requestType) {
            case "POST":
                $this->requestType = "POST";
                break;
            case "GET":
                $this->requestType = "GET";
                break;
            case "PUT":
                $this->requestType = "PUT";
                break;
            case "DELETE":
                $this->requestType = "DELETE";
                break;
            case "HEAD":
                $this->requestType = "HEAD";
                break;
            case "TRACE":
                $this->requestType = "TRACE";
                break;
            case "CONNECT":
                $this->requestType = "CONNECT";
                break;
            case "OPTIONS":
                $this->requestType = "OPTIONS";
                break;
        }
        return $this->requestType;
    }



    public function getFilteredPostVariable(string $variableName) : object {
        $output = '';
        if ($this->getRequestType() == "POST") {
            $messageBodyArray = array();
            parse_str($this->getRequestBody(), $messageBodyArray);

            if (array_key_exists($variableName, $messageBodyArray)) {
                $output = $messageBodyArray[$variableName];
            }
        }
        // return $output;
        // $output = filter_input(INPUT_POST, 'method', FILTER_FORCE_ARRAY);
        // return $output;
        return json_decode($this->getRequestBody());
    }


    public function getFilteredGetVariable(string $variableName) : string {
        $output = " ";
        if ($this->getRequestType() == "GET" && filter_input(INPUT_GET, $variableName) != null) {
            $output = filter_input(INPUT_GET, $variableName);
        }
        return $output;
    }

    public function getRequestBodyAsObject() : object  {
        $messageBodyArray = array();
        parse_str($this->getRequestBody(), $messageBodyArray);

        // return $messageBodyArray;
        // return json_decode($this->getBodyAsString());
        return json_decode($this->getRequestBody());
    }

    public function getRequestBody() : string {
        $output = "";
        $messageBody = file_get_contents("php://input");
        if ($messageBody != "") {
            $output = $messageBody;
        }
        return $output;
    }


    public function getRequestBodyParameter(string $parameterName) : string {
        $value = "";
        $messageBodyArray = array();
        parse_str($this->getRequestBody(), $messageBodyArray);
        if(array_key_exists($parameterName, $messageBodyArray)) {
            $value = $messageBodyArray[$parameterName];
        }
        return $value;
    }


    /**
     * Retrieves the query from the url and returns it as an associative array in the form of
     * param1=value1&param2=value2&.... <br><br>
     *
     * Example: http://www.example.com/filename.php?param1=value1&param2=value2
     * @return array    The associative array consisting of the query
     */
    public function getQueryFromUrl() : array {
        $queryArray = array();
        parse_str(filter_input(INPUT_SERVER, "QUERY_STRING"), $queryArray);
        return $queryArray;
    }

    public function getRequestURI(): array {
        $requestUri = explode("/", $_SERVER['REQUEST_URI']);
        unset($requestUri[0]);
        unset($requestUri[1]);

        $requestUriArray = array();
        foreach ($requestUri as $part) {
            array_push($requestUriArray, $part);
        }
        return $requestUriArray;
    }

    public function getRequestHeaders(): array {

    }

    public function getEntityName(): string {
        return $this->getRequestURI()[0];
    }
}



?>
