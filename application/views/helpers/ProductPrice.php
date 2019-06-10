<?php
class Zend_View_Helper_ProductPrice extends Zend_View_Helper_Abstract
{
	public function productPrice($car)
	{
		$price=$car->prezzo;
		$currency = new Zend_Currency();
		$formatted = '<p>' . $currency->toCurrency($price) . '</p>';
		return $formatted;
	}
}