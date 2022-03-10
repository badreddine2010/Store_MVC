<?php



class ProductTest extends PHPUnit\Framework\TestCase

{

    public function testSetNom()
    {
        $prod = new Product;
        $value = 'livre';
        $prod->setName($value);
        $this->assertEquals($value, $prod->getName());
    }
    public function testGetAllProducts(){

        $this->assertEquals(array(),getAllProducts());
    }
    public function testAddProduct(){

        $this->assertEquals(true,addNewProduct(1));
    }
    public function testGetProductById(){

        $this->assertEquals(array(),getProductById(1));
    }

    public function testDelProduct(){

        $this->assertEquals(true,delProductById(1));
    }
    public function testUpdateProduct(){

        $this->assertEquals(true,updateProduct('sirop',1));
    }


}
