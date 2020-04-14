<?php
/**
 * Author: seef
 * Date: 05-04-20
 * Time: 18:53
 */

namespace httprequest;

class TestClass {
    private $name;

    public function __construct(string $name) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }
}

