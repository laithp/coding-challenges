<?php

class UnitFramework
{

    public $classname = null;
    public $testcount = 0;
    public $pass = 0;
    public $fail = 0;

    public $testdescription = "";

    function __construct($name)
    {
        $this->classname = $name;
    }

    function summary() {
        echo "===================\n";
        echo "  TESTS COMPLETED  \n";
        echo " Tests Run: ".$this->testcount."\n";
        echo " Pass: ".$this->pass." Fail: ".$this->fail."\n";
    }

    function testDescription($description)
    {
        $this->testdescription = $description;
    }

    function testPass()
    {
        $this->pass++;
        echo $this->testdescription . "\n";
        echo "PASS!\n\n";
    }
    function testFail($message)
    {
        $this->fail++;
        echo $this->testdescription . "\n";
        echo "FAIL!\n";
        echo $message;
    }

    function assertEqual($expected, $actual)
    {
        $this->testcount++;
        if ($expected == $actual) {
            $this->testPass();
        } else {
            $this->testFail("Expected: " . $expected . "\nActual: " . $actual . "\n\n");
        }
    }
}
