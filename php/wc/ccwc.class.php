<?php
/**
* ccwc class file implementation of the wc tool
*
*/

class CCWC {

    const FILECHUNKSIZE = 100000;

    public $file = null;

    public $bytesflag = false;
    public $bytecount = 0;
        public $charsflag = false;

    public $linesflag = false;
    public $linecount = 0;

    public $wordsflag = false;
    public $wordcount = 0;

    function __construct($argc, $argv)
    {

        if($argc<2){
            $this->set_all_flags();
            $this->file = STDIN;
        }elseif($argc<3){
            if($this->parse_flags($argv[1])){
                $this->file = STDIN;
            }else{
                $this->file = fopen($argv[1],"r");
            } 
        }else{
            $this->parse_flags($argv[1]);
            $this->file = fopen($argv[2],"r");
        }

        //$this->file = fopen($filename,"r");
        
        while($filestring = fgets($this->file)){
        //while($filestring = fread($this->file,self::FILECHUNKSIZE)){

            if($this->bytesflag || $this->charsflag){
                $this->bytecount = $this->get_bytecount($this->bytecount, $filestring);
            }
            if($this->linesflag){
                $this->linecount = $this->get_linecount($this->linecount, $filestring);
            }
            if($this->wordsflag){
                $this->wordcount = $this->get_wordcount($this->wordcount, $filestring);
                //$this->wordcount = $this->php_get_wordcount($this->wordcount, $filestring);
            }

        }

        if($this->bytesflag || $this->charsflag){
            echo $this->bytecount;
            echo " ";
        }
        if($this->linesflag){
            echo $this->linecount;
            echo " ";
        }
        if($this->wordsflag){
            echo $this->wordcount;
            echo " ";
        }
        //echo $filename;
       
        
    }

    function parse_flags($param){
        $hasparams = false;
        if(substr($param,0,1)=='-'){
            $this->bytesflag = (strstr($param,'c'))?true:false; //bytes in file
                $this->charsflag = (strstr($param,'m'))?true:false; //characters in file - my locale doesn't support multibyte

            $this->linesflag = (strstr($param,'l'))?true:false; //lines in file

            $this->wordsflag = (strstr($param,'w'))?true:false; //words in file
            $hasparams = true;
        }

        if(!$this->bytesflag && !$this->linesflag && !$this->wordsflag && !$this->charsflag){
            $this->set_all_flags();
        }
        return $hasparams;
    }

    function set_all_flags(){
        $this->bytesflag = true;
        $this->linesflag = true;
        $this->wordsflag = true;
    }

    function get_bytecount($bytecount, $filestring) {
        // -c
        //This function will open the file 
        // and by iterating over it get the number of bytes
        //
        // expected result from cc test.txt = 342190 
        //
        // NOTE: a simple way to do it would be to just use the php internal filesize()
    
        $bytecount += strlen($filestring);
        return $bytecount;
    }

    function get_linecount($linecount, $filestring) {
        // -l
        //This function will open the file
        // and by iterating over it and counting the number of newlines
        // determine the number of lines in the file 
        //
        // expected result from cc test.txt = 7145 
        //
        // first pass I used strpos, however this resulted in an undercount when there are blank lines
        //
        // NOTE: - simpler way ? -
        
            //$pieces = explode("\n",$filestring);
           // $linecount = $linecount + count($pieces) - 1 ; // subtracting 1 fixes for an overcount condition
            $linecount++;

        return $linecount;
    }

    function get_wordcount($wordcount, $filestring) {
        // -w
        //This function will open the file and itterate
        // to get the wordcount
        //
        // expected result from cc text.txt = 58164 
        // 
        // NOTE: - simpler way use str_word_count() ?

            if(strlen(trim($filestring))>0){ 
                $words = explode(" ",$filestring);
                foreach($words as $word){
                    if(strlen(trim($word))>0){
                        $wordcount++;
                    }
                }
                
            }
             
        return $wordcount;

    }

    //direct php call methods
    function php_get_wordcount($wordcount, $filestring) {
        //Simpler way using str_word_count()
        //
        // expected result from cc text.txt = 58164 

            $wordcount += str_word_count($filestring);
        
        return $wordcount;
    }

    function php_get_bytecount($filename) {
        //simpler using filesize()
        //
        // expected result from cc test.txt = 342190 
        return filesize($filename);
    }

    function report_error($message){
        echo $message;
    }

}