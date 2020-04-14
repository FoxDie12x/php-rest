<?php
/**
 * Created by PhpStorm.
 * Author: seef
 * Date: 03-04-20
 * Time: 12:32
 */

namespace httprequest;

class RequestProcessor {
    public const POST = "POST";
    public const PUT = "PUT";
    public const GET = "GET";
    public const DELETE = "DELETE";
    public const HEAD = "HEAD";
    public const TRACE = "TRACE";
    public const CONNECT = "CONNECT";
    public const OPTIONS = "OPTIONS";
    public const PATCH = "PATCH";

    private $requestType;

    public function __construct() {}

    public function getRequestType() : string {
        $this->requestType = filter_input(INPUT_SERVER, "REQUEST_METHOD");
        switch ($this->requestType) {
            case self::POST:
                $this->requestType = self::POST;
                break;
            case self::PUT:
                $this->requestType = self::PUT;
                break;
            case self::GET:
                $this->requestType = self::GET;
                break;
            case self::DELETE:
                $this->requestType = self::DELETE;
                break;
            case self::HEAD:
                $this->requestType = self::HEAD;
                break;
            case self::TRACE:
                $this->requestType = self::TRACE;
                break;
            case self::CONNECT:
                $this->requestType = self::CONNECT;
                break;
            case self::OPTIONS:
                $this->requestType = self::OPTIONS;
                break;
            case self::PATCH:
                $this->requestType = self::PATCH;
                break;
        }
        return $this->requestType;
    }


    public function getFilteredPostVariable(string $variableName) : object {
        $output = '';
        if ($this->getRequestType() == self::POST) {
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

    /**
     * @return array
     * @throws \Exception
     */
    public function getUri(): array {
        $uri = (substr($_SERVER["REQUEST_URI"], -1, 1) == '/') ? substr($_SERVER["REQUEST_URI"], 0, -1) : $_SERVER["REQUEST_URI"];
        $requestUri = explode("/", $uri);
        unset($requestUri[0]);
        unset($requestUri[1]);

        $requestUriArray = array();
        foreach ($requestUri as $part) {
            if (empty($part))
                throw new \Exception('incorrect URI');
            array_push($requestUriArray, $part);
        }
        return $requestUriArray;
    }

    public function getResourceName(): string {
        return ucfirst($this->getUri()[0]);
    }

    public function getResourceId(): int {
        try {
            if (count($this->getUri()) <= 1 || !is_numeric($this->getUri())) {
                return -1;
            }
            return intval($this->getUri()[1]);
        } catch (\Exception $ex) {
            return -1;
        }

    }

    public function getHost(): string {
        return $_SERVER['HTTP_HOST'];
    }

    /**
     * Fetches all headers of the current HTTP request
     * @return array    An array of all headers or an empty array if headers could not get fetched.
     */
    public function getCurrentRequestHeaders(): array {
        $currentRequestHeaders = apache_request_headers();
        if (!$currentRequestHeaders) {
            return [];
        }
        return $currentRequestHeaders;
    }
}



?>
