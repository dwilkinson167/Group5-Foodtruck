<?php
class Cart
{

    protected static $_instance = NULL;


    protected $_id = NULL;


    protected $_items = array();


    protected $_tax = array();


    protected $_persistance = null;


    private function __construct() {}


    public function getInstance()
    {
        if (NULL === self::$_instance) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }


    //Add Tax
    public function addTax($key = NULL, $amount = NULL)
    {

        if (NULL === $key) {
            throw new Exception('Tax key cannot be null');
        }

        if (NULL === $amount) {
            throw new Exception('Tax amount cannot be null');
        }

        $this->_tax[$key] = $amount;
        return $this->_save();
    }


    //Add product
    public function add(Product_Interface $product)
    {
        if (isset($this->_items[$product->id])) {
            $this->_items[$product->id]['amount']++;
        } else {
            $this->_items[$product->id]['item'] = $product;
            $this->_items[$product->id]['amount'] = 1;
        }

        return $this->_save();
    }


    //Remove product
    public function remove($productId = NULL)
    {
        if (NULL === $productId) {
            return FALSE;
        }
        if (isset($this->_items[$productId])) {
            // if amount of products is 1, remove product, otherwise decrease amount
            if (1 == $this->_items[$productId]['amount']) {
                unset($this->_items[$productId]);
            } else {
                $this->_items[$productId]['amount']--;
            }
        }

        return $this->_save();
    }


    //Empty Cart
    public function removeAll()
    {
        $this->_items = array();

        return $this->_save();
    }


  //Call Cart items
    public function getAll()
    {
        return $this->_items;
    }


    //Calculate sum
    protected function _getTotal()
    {
        $total = 0;

        foreach ($this->_items as $item) {
            $total += $item['item']->getCost() * $item['amount'];
        }

        return $total;
    }


    //Calculate sum with tax
    public function getTotal()
    {
        $total = $this->_getTotal();

        if ( ! empty($this->_tax)) {
            foreach ($this->_tax as $tax) {
                $total += $total * $tax;
            }
        }

        return number_format($total, 2);
    }


    //Save Current state of cart
    protected function _save()
    {
        $contents['tax'] = $this->_tax;
        $contents['items'] = $this->_items;

        $this->_persistance->setContents($contents);
        $this->_persistance->save();

        return $this;
    }


    //Load Cart contents from persistence object
    protected function _load()
    {
        $contents = $this->_persistance->load()->getContents();

        $this->_tax = $contents['tax'];
        $this->_items = $contents['items'];

        return $this;
    }


    //Set persistance object
    public function setPersistance(Persistance_Interface $persistance)
    {
        $this->_persistance = $persistance;

        // set Cart id in persitance
        if (NULL !== $this->_id) {
            $this->_persistance->setId($this->id);
        }

        // load from persistance
        $contents = $this->_persistance->load()->getContents();

        $this->_tax = $contents['tax'];
        $this->_items = $contents['items'];

        return $this;
    }


    //Set cart id
    public function setId($id = NULL)
    {
        if (NULL === $id) {
            throw new Exception('Cannot set NULL id');
        }

        $this->_id = $id;

        // set the same id to persistance
        $this->_persistance->setId($this->_id);

        return $this;
    }

   //Fetch ID
    public function getId()
    {
        return $this->_id;
    }
}
