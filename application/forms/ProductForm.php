<?php

class Application_Form_ProductForm extends Zend_Form
{

    public function init()
    {
        $this->setMethod('POST');
        
        //product name :
        $name =new Zend_Form_Element_Text('name');
        $name->setLabel('Product Name');
        $name->setAttribs(['placeholder'=>'e.g. lenovo phone',
            'class'=>'form-control']);
        $name->setRequired();
        $name->addFilter('StringTrim');
        
        $name_ar =new Zend_Form_Element_Text('name_ar');
        $name_ar->setLabel('Product Name');
        $name_ar->setAttribs(['placeholder'=>'e.g. هاتف لينوفو',
            'class'=>'form-control']);
        $name_ar->addFilter('StringTrim');
        
        // product description :
        $description =new Zend_Form_Element_Textarea('description');
        $description->setLabel('Product Description :');
        $description->setAttribs(['placeholder'=>'description',
            'class'=>'form-control', "rows" => "10", "style" => "resize: none;"]);
        $description->setRequired();
        $description->addFilter('StringTrim');
        
        $description_ar=new Zend_Form_Element_Textarea('description_ar');
        $description_ar->setLabel('Product Description :');
        $description_ar->setAttribs(['placeholder'=>'وصف المنتج',
            'class'=>'form-control', "rows" => "10", "style" => "resize: none;"]);
        $description_ar->addFilter('StringTrim');
        
        // product quantity:
        $quantity =new Zend_Form_Element_Text('quantity');
        $quantity->setLabel('Product Quantity :');
        $quantity->setAttribs(['placeholder'=>'e.g. 10',
            'class'=>'form-control']);
        $quantity->setRequired();
        $quantity->addFilter('StringTrim');
        
        // product quantity:
        $price =new Zend_Form_Element_Text('price');
        $price->setLabel('Product Price :');
        $price->setAttribs(['class' => 'form-control', 'placeholder' => "e.g. 40"]);
        $price->setRequired();
        $price->addFilter('StringTrim');
        
        //product Image
        $photo =new Zend_Form_Element_File('photo');
        $photo->setLabel('Upload an Image :');
        $photo->addValidator('Count',false,1);
        $photo->addValidator('Extension', false, 'jpg,png,gif');
        $photo->setAttrib('enctype', 'multipart/form-data');
        
        $photo->setDestination("images");
        

        
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
        
        $this->addElements([$name,$categoryId,$description,$price,$quantity,$photo,$submit,$reset, $name_ar, $description_ar]);
    
        
    }


}

