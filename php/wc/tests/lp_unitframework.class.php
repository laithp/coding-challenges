<?php

class UnitFramework
{

    public $classname = null;

    public $teststrings = null;
    public $testcount = 0;
    public $pass = 0;
    public $fail = 0;

    public $testdescription = "";

    function __construct($name)
    {
        $this->classname = $name;
    }

    function summary()
    {
        $this->teststrings .= "===================\n";
        $this->teststrings .= "  TESTS COMPLETED  \n";
        $this->teststrings .= "===================\n";
        $this->teststrings .= " Tests Run: " . $this->testcount . "\n";
        $this->teststrings .= " Pass: " . $this->pass . " Fail: " . $this->fail . "\n";

        echo $this->teststrings;
    }

    function testDescription($description)
    {
        $this->testcount++;
        
        $this->teststrings .= $description;
    }

    function testResults($resultsbool){
         $this->teststrings .= ($resultsbool)?": PASS!\n\n":": !FAIL!\n\n";
         ($resultsbool)?$this->pass++:$this->fail++;
    }
    function testPass()
    {
        $this->pass++;
        $this->teststrings .= ": PASS!\n\n";
    }
    function testFail($message)
    {
        $this->fail++;
        $this->teststrings .=  ": FAIL!\n";
        $this->teststrings .=  $message;
    }

    function assertEqual($expected, $actual)
    {
        if ($expected == $actual) {
            //$this->testPass();
            return true;
        } else {
            $this->teststrings .= "Expected: " . $expected . " Actual: " . $actual . "\n\n";
            return false;
            
        }
    }
}
