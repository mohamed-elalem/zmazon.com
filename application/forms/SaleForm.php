<?php

class Application_Form_SaleForm extends Zend_Form
{

    public function init()
    {
        $this->setMethod('POST');
        
        $productModel =new Application_Model_Product();
        $allProducts = $productModel->listAllProducts();
        $productId = new Zend_Form_Element_Select('productId');
        $productId->setLabel('Select Product : ');
        $productId->setAttrib('class', 'form-control');
        $productId->setRequired();
        foreach ($allProducts as $key => $value)
        {
            $productId->addMultiOption($value['id'], $value['name']);
        }
        
        $endDate = new Zend_Form_Element_Text('endDate');
        $endDate->setLabel('End date of sale :');
        $endDate->setRequired();
        $endDate->setAttrib('class', 'form-control');
        
        $startDate = new Zend_Form_Element_Text('startDate');
        $startDate->setLabel('Start date of sale :');
        $startDate->setRequired();
        $startDate->setAttrib('class', 'form-control');
        
        $percentage = new Zend_Form_Element_Text('percentage');
        $percentage->setLabel('Percentage of sale %:');
        $percentage->setRequired();
        $percentage->setAttrib('class', 'form-control');
        
        // submit button 
        $submit =new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('class', 'btn btn-danger');
        
        // reset button 
        $reset =new Zend_Form_Element_Reset('reset');
        $reset->setAttrib('class', 'btn btn-danger');
        
        $this->addElements([$productId,$percentage,$startDate,$endDate,$submit,$reset]);
    }


}

