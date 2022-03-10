<?php



class UserTest extends PHPUnit\Framework\TestCase

{

    public function testSetNom()
    {
        $user = new User;
        $value = 'livre';
        $user->setNom($value);
        $this->assertEquals($value, $user->getNom());
    }
}