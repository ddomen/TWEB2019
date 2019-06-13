<?php
class Zend_View_Helper_ProductPrice extends Zend_View_Helper_Abstract
{
	public function productPrice($car)
	{
		$price=$car->Prezzo;
		$currency = new Zend_Currency('IT');
		$formatted = '<p align="right" style="font-size: 2em">' . $currency->toCurrency($price) . '</p>';
		return $formatted;
	}
}