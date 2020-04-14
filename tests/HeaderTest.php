<?php
/**
 * Created by PhpStorm.
 * Author: seef
 * Date: 03-04-20
 * Time: 14:46
 */

use PHPUnit\Framework\TestCase;
use \httpmessage\Header;
use \httpmessage\HeaderField;
use \exceptions\IncorrectHeaderFieldException;

class HeaderTest extends TestCase {


    public function testIfIncorrectHeaderInstantiationThrowsException(): void {
        $this->expectException(IncorrectHeaderFieldException::class);

        $headerField = HeaderField::ACCEPT_CHARSET;
        $header = new Header($headerField, 'test');
    }

    /**
     * Determines if multiple header field values are formatted as a comma-seperated string
     *
     */
    public function testHeaderFieldValuesAreOfCorrectFormat(): void {
        // ARRANGE
        $pattern = ''; // TODO: implementation using regex required

        $fieldValues = [];
        for ($x = 0; $x < 5; $x++) {
            array_push($fieldValues, "randomField-" . $x);
        }

        // Create a new Header
        $header = new Header(HeaderField::ACCEPT, $fieldValues);

        // ACT
        $headerString = $header->toString();


        // Assert
        $this->assertMatchesRegularExpression($pattern, $header->toString());
    }
}

?>
