<?php
include_once 'lib/Product/Interface.php';
abstract class Product_Abstract implements Product_Interface
{

    protected $_description = NULL;

    protected $_cost = NULL;

    protected  $_name = NULL;

    protected $_attributes = array();

    //Start Set functions
    public function setCost($cost = NULL)
    {
        if (NULL === $cost OR !is_numeric($cost)) {
            throw new Exception('Cost cannot be null');
        }

        $this->_cost = (float) $cost;

        return $this;
    }


    public function setDescription($description = NULL)
    {
        if (NULL === $description) {
            throw new Exception('Description cannot be null');
        }

        $this->_description = $description;

        return $this;
    }


    public function setName($name = NULL)
    {
        if (NULL === $name) {
            throw new Exception('Name cannot be null');
        }

        $this->_name = $name;

        return $this;
    }#End set functions

   //Start get functions
    public function getCost()
    {
        return number_format($this->_cost, 2);
    }


    public function getDescription()
    {
        return $this->_description;
    }


    public function getName()
    {
        return $this->_name;
    }

    public function __get($key)
    {
        if (isset($this->_attributes[$key])) {
            return $this->_attributes[$key];
        } else {
            return NULL;
        }
    }#End get functions




    public function __set($key = NULL, $value = NULL)
    {
        if (NULL === $key OR NULL === $value) {
            throw new Exception('Key and value for setting an attribute must be set');
        }

        $this->_attributes[$key] = $value;
    }


    public function __isset($key)
    {
        switch($key) {
            case 'cost':
                return isset($this->_cost);
                break;

            case 'description':
                return isset($this->_description);
                break;

            case 'name':
                return isset($this->_name);
                break;

            default:
                return isset($this->_attributes[$key]);
                break;
        }
    }

}