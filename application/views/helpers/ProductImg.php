<?php
class Zend_View_Helper_ProductImg extends Zend_View_Helper_HtmlElement
{

    private $_attrs;
	
	public function productImg($imgFile, $attrs = false)
	{
		if (empty($imgFile)) {
			$imgFile = 'default.jpg';
		}
		if (null !== $attrs) {
			$_attrs = $this->_htmlAttribs($attrs); //htmlAttribs() converte l'array che gli passiamo in una serie di attributi che poi diventeranno gli attributi della tag img
		} else {
			$_attrs = '';
		}
		$tag = '<img src="' . $this->view->baseUrl('images/vetture/' . $imgFile) . '" ' . $_attrs . '>';
		return $tag;
	}
}

