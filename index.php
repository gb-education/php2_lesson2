<?
/*

1. Создать структуру классов ведения товарной номенклатуры.
Есть абстрактный товар.
Есть цифровой товар, штучный физический товар и товар на вес.
У каждого есть метод подсчёта финальной стоимости.
У цифрового товара стоимость постоянная и дешевле штучного товара в два раза, у штучного товара обычная стоимость, у весового – в зависимости от продаваемого количества в килограммах. У всех формируется в конечном итоге доход с продаж.
Что можно вынести в абстрактный класс, наследование?

*/

abstract class Products
{
	abstract protected function digProd();
	abstract protected function pieceProd();
	abstract protected function weightProd();

	public static $price = 100; /* цена цифрового товара */
}

class calcPrice extends Products
{
	public $mount; /* количество */ 
	public $wprice; /* цена весового товара */

	public function digProd()
	{
		return static::$price * $this->mount;
	}

	public function pieceProd()
	{
		return static::$price * 2 * $this->mount;
	}

	public function weightProd()
	{
		return $this->wprice * $this->mount;
	}

	function __construct($mount,$wprice = null)
	{
		$this->mount = $mount;
		$this->wprice = $wprice;
	}
}

$digProdObj = new calcPrice(15);
echo $digProdObj->digProd() . "<br>";

$pieceProdObj = new calcPrice(10);
echo $pieceProdObj->pieceProd() . "<br>";

$weightProdObj = new calcPrice(15,25);
echo $weightProdObj->weightProd() . "<br>";

/* ---------------------------------------------------------- */

/* 
2. * Реализовать паттерн Singleton при помощи traits.
*/




trait singleton {    
    /**
     * private construct, generally defined by using class
     */
    //private function __construct() {}
    
    public static function getInstance() {
        static $_instance = NULL;
        $class = __CLASS__;
        return $_instance ?: $_instance = new $class;
    }
    
    public function __clone() {
        trigger_error('Cloning '.__CLASS__.' is not allowed.',E_USER_ERROR);
    }
    
    public function __wakeup() {
        trigger_error('Unserializing '.__CLASS__.' is not allowed.',E_USER_ERROR);
    }
}

/**
* Example Usage
*/

class foo {
    use singleton;
    
    private function __construct() {
        $this->name = 'foo';
    }
}

class bar {
    use singleton;
    
    private function __construct() {
        $this->name = 'bar';
    }
}

$foo = foo::getInstance();
echo $foo->name;

$bar = bar::getInstance();
echo $bar->name;