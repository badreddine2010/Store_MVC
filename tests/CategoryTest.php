<?php


class CategoryTest extends PHPUnit\Framework\TestCase
{

    public function testSetNom()
    {
        $cat = new Category;
        $value = 'fruits';
        $cat->setNom($value);
        $this->assertEquals($value, $cat->getNom());
    }
    public function testGetAllCategories(){

        $this->assertEquals(array(),getAllCategories());
    }
    public function testAddCategory(){

        $this->assertEquals(true,addCategory(1));
    }
    public function testGetCategoryById(){

        $this->assertEquals(false,getCategoryById(1));
    }

    public function testDelCategory(){

        $this->assertEquals(true,deleteCategoryById(1));
    }
    public function testUpdateCategory(){

        $this->assertEquals(true,updateCategory('fruit',1));
    }
}
