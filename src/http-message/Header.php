<?php
/**
 * Created by PhpStorm.
 * Author: seef
 * Date: 03-04-20
 * Time: 13:48
 */

namespace httpmessage;

use \exceptions\IncorrectHeaderFieldException;
use ReflectionClass;

class Header {
    private $field = '';
    private $values = [];

    /**
     * Header constructor.
     * @param string $field
     * @param array $values
     * @throws IncorrectHeaderFieldException
     */
    public function __construct(string $field, array $values) {
        if (!$this->isCorrectHeaderField($field)) {
            throw new IncorrectHeaderFieldException('test');
        }
        $this->field = $field;
        $this->values = $values;
    }


    /**
     * Returns the string representation of this header
     * @return string
     */
    public function toString(): string {
        $valuesAsString = '';
        for ($x = 0; $x < count($this->values); $x++) {
            $valuesAsString .= $this->values[$x];
            if ($x < count($this->values) - 1) {
                $valuesAsString .= ", ";
            }
        }
        return $this->field . ':' . $valuesAsString;
    }


    /**
     * Checks if the header field name is valid by verifying if a corresponding constant exists in the HeaderField class.
     * @param string $fieldName
     * @return bool
     */
    private function isCorrectHeaderField(string $fieldName): bool {
        try {
            $reflection = new ReflectionClass(HeaderField::class);
            $constants = $reflection->getConstants();
            foreach ($constants as $field => $value) {
                if ($value === trim(strtolower($fieldName))) {
                    return true;
                    break;
                }
            }
        } catch(\ReflectionException $ex) {
            return false;
        }
        return false;
    }

}
