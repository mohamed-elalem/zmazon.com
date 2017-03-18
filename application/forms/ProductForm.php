<?php

class Application_Form_ProductForm extends Zend_Form
{

    public function init()
    {
        $this->setMethod('POST');
        
        //product name :
        $name =new Zend_Form_Element_Text('name');
        $name->setLabel('Product Name :');
        $name->setAttribs(['placeholder'=>'lenovo phone',
            'class'=>'form-control']);
        $name->setRequired();
        $name->addFilter('StringTrim');
        
        // product description :
        $description =new Zend_Form_Element_Textarea('description');
        $description->setLabel('Product Description :');
        $description->setAttribs(['placeholder'=>'description',
            'class'=>'form-control']);
        $description->setRequired();
        $description->addFilter('StringTrim');
        
        // product quantity:
        $quantity =new Zend_Form_Element_Text('quantity');
        $quantity->setLabel('Product Quantity :');
        $quantity->setAttribs(['placeholder'=>'',
            'class'=>'form-control']);
        $quantity->setRequired();
        $quantity->addFilter('StringTrim');
        
        // product quantity:
        $price =new Zend_Form_Element_Text('price');
        $price->setLabel('Product Price :');
        $price->setAttrib('class','form-control');
        $price->setRequired();
        $price->addFilter('StringTrim');
        
        //product Image
        $photo =new Zend_Form_Element_File('photo');
        $photo->setLabel('Upload an Image :');
        $photo->addValidator('Count',false,1);
        $photo->addValidator('Extension', false, 'jpg,png,gif');
        $photo->setAttrib('enctype', 'multipart/form-data');
        
        $photo->setDestination(APPLICATION_PATH.'/../public/images');
        

        
        // product category
        $categoryModel =new Application_Model_Category();
        $allCategories =$categoryModel->retrieveAll();
        $categoryId =new Zend_Form_Element_Select('categoryId');
        $categoryId->setLabel('Category :');
        $categoryId->setRequired();
        $categoryId->setAttrib('class', 'form-control');
        foreach($allCategories as $key => $value)
        {
            $categoryId->addMultiOption($value['id'], $value['name']);       
        }
        
        
        // submit button 
        $submit =new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('class', 'btn btn-danger');
        
        // reset button 
        $reset =new Zend_Form_Element_Reset('reset');
        $reset->setAttrib('class', 'btn btn-danger');
        
        $this->addElements([$name,$categoryId,$description,$price,$quantity,$photo,$submit,$reset]);
    
        
    }


}

