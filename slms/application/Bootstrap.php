<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initSession()
	{
		Zend_Session::start();
		$session = new Zend_Session_Namespace('my_space');
		$session->setExpirationSeconds( 1800 );
	}
	protected function _initPlaceholders()
	{
		$this->bootstrap('View');
		$view = $this->getResource('View');
		$view->doctype('XHTML1_STRICT');
		$view->headMeta()->appendName('keywords', 'framework, PHP')->appendHttpEquiv('Content-Type','text/html;charset=utf-8');
		// Set the initial title and separator:
		$view->headTitle('Zend Proj')->setSeparator(' :: ');
		// Set the initial stylesheet:
		$view->headLink()->appendStylesheet('css/animate.css');
		$view->headLink()->appendStylesheet('css/bootstrap.min.css');
		$view->headLink()->appendStylesheet('css/superslides.css');
		$view->headLink()->appendStylesheet('css/slick.css');
		$view->headLink()->prependStylesheet('css/jquery.tosrus.all.css');
		$view->headLink()->prependStylesheet('css/themes/default-theme.css');
		$view->headLink()->prependStylesheet('http://fonts.googleapis.com/css?family=Merriweather');
		$view->headLink()->prependStylesheet('http://fonts.googleapis.com/css?family=Varela');
		// Circle counter cdn css file 
    	$view->headLink()->appendStylesheet('https://cdn.rawgit.com/pguso/jquery-plugin-circliful/master/css/jquery.circliful.css');  
    	$view->headLink()->appendStylesheet('css/animate.css');  
    	$view->headLink()->appendStylesheet('css/queryLoader.css');
    	$view->headLink()->appendStylesheet('css/jquery.tosrus.all.css');
    	$view->headLink()->appendStylesheet('css/themes/default-theme.css');
    	$view->headLink()->appendStylesheet('style.css');
    	$view->headLink()->appendStylesheet('myStyle.css');


		// Set the initial JS to load:
		$view->headScript()->appendFile('js/jquery-1.12.3.js');
		$view->headScript()->appendFile('js/jquery.min.js');
		$view->headScript()->appendFile('js/bootstrap.min.js');
		$view->headScript()->appendFile('js/queryloader2.min.js');
		$view->headScript()->appendFile('js/wow.min.js');
		$view->headScript()->appendFile('js/slick.min.js');
		$view->headScript()->appendFile('js/jquery.easing.1.3.js');
		$view->headScript()->appendFile('js/jquery.animate-enhanced.min.js');
		$view->headScript()->appendFile('js/jquery.superslides.min.js');
		$view->headScript()->appendFile('js/jquery.tosrus.min.all.js');
		$view->headScript()->appendFile('js/custom.js');
		$view->headScript()->appendFile('https://cdn.rawgit.com/pguso/jquery-plugin-circliful/master/js/jquery.circliful.min.js');
		

}
}

