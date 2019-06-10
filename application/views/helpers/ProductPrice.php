<?php
class Zend_View_Helper_ProductPrice extends Zend_View_Helper_Abstract
{
	public function productPrice($car)
	{
		$price=$car->prezzo;
		$currency = new Zend_Currency('IT');
		$formatted = '<p align="right">' . $currency->toCurrency($price) . '</p>';
		return $formatted;
	}
}