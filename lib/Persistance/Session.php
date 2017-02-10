<?php
include 'lib/Persistance/Interface.php';
class Persistance_Session implements Persistance_Interface
{

protected $_namespaceDefault = 'default_persistance';


protected $_namespaceId = NULL;


protected $_contents = array();


public function __construct($namespace = NULL)
{
session_start();

if (NULL !== $namespace) {
$this->_namespaceId = $namespace;
} else {
$this->_namespaceId = $this->_namespaceDefault;
}

if ( ! isset($_SESSION[$this->_namespaceId])) {
$_SESSION[$this->_namespaceId] = array();
}
}


public function setId($id = NULL)
{
if (NULL === $id) {
throw new Exception('id cannot be NULL');
}

$this->_namespaceId = $id;

return $this;
}


public function getId()
{
return $this->_namespaceId;
}


public function load($id = NULL)
{
if ( NULL !== $id) {
$this->setId($id);
}

$this->_contents = $_SESSION[$this->_namespaceId];

return $this;
}


public function save($id = NULL)
{
if ( NULL !== $id) {
$this->setId($id);
}

$_SESSION[$this->_namespaceId] = $this->_contents;
}


public function getContents()
{
return $this->_contents;
}


public function setContents($contents = NULL)
{
if (NULL === $contents || empty($contents)) {
$this->emptyContents();
}
$this->_contents = $contents;
return $this;
}


public function emptyContents()
{
$this->_contents = array();
return $this;
}

}