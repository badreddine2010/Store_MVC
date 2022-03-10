<?php

require 'src/model/dbaccess.php';

class DbaccessTest extends PHPUnit\Framework\TestCase
{

    public function testDbaccess(){

        $this->assertEquals(false,dbConnect());
        
    }
}