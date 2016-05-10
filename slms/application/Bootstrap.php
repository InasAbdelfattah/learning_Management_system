<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
        protected function _initRequest() {
            $this->bootstrap('FrontController');
            $front = $this->getResource('FrontController');
            $request = new Zend_Controller_Request_Http();
            $front->setRequest($request);
        }
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
		$view->headLink()->appendStylesheet($view->baseUrl().'/css/animate.css');
		$view->headLink()->appendStylesheet($view->baseUrl().'/css/bootstrap.min.css');
		$view->headLink()->appendStylesheet($view->baseUrl().'/css/superslides.css');
		$view->headLink()->appendStylesheet($view->baseUrl().'/css/slick.css');
		$view->headLink()->appendStylesheet($view->baseUrl().'/css/jquery.tosrus.all.css');
		$view->headLink()->appendStylesheet($view->baseUrl().'/css/themes/default-theme.css');
		
		// Circle counter cdn css file 
                $view->headLink()->appendStylesheet($view->baseUrl().'/css/jquery.circliful.css');  
                $view->headLink()->appendStylesheet($view->baseUrl().'/css/animate.css');  
                $view->headLink()->appendStylesheet($view->baseUrl().'/css/style.css');
                $view->headLink()->appendStylesheet($view->baseUrl().'/css/jquery.tosrus.all.css');
                $view->headLink()->appendStylesheet($view->baseUrl().'/css/themes/default-theme.css');
                $view->headLink()->appendStylesheet($view->baseUrl().'/style.css');
                //admin panal css links
                $view->headLink()->appendStylesheet($view->baseUrl().'/css/sb-admin.css');
                $view->headLink()->appendStylesheet($view->baseUrl().'/css/plugins/morris.css');
                $view->headLink()->appendStylesheet($view->baseUrl().'/font-awesome/css/font-awesome.min.css');
    	


		// Set the initial JS to load:
                $view->headScript()->appendFile($view->baseUrl().'/js/jquery-1.9.1.js');
                $view->headScript()->appendFile($view->baseUrl().'/js/jquery-1.12.3.js');
		$view->headScript()->appendFile($view->baseUrl().'/js/jquery.min.js');
		$view->headScript()->appendFile($view->baseUrl().'/bootstrap.min.js');
		$view->headScript()->appendFile($view->baseUrl().'/js/queryloader2.min.js');
		$view->headScript()->appendFile($view->baseUrl().'/js/wow.min.js');
		$view->headScript()->appendFile($view->baseUrl().'/js/slick.min.js');
		$view->headScript()->appendFile($view->baseUrl().'/js/jquery.easing.1.3.js');
		$view->headScript()->appendFile($view->baseUrl().'/js/jquery.animate-enhanced.min.js');
		$view->headScript()->appendFile($view->baseUrl().'/js/jquery.superslides.min.js');
		$view->headScript()->appendFile($view->baseUrl().'/js/jquery.tosrus.min.all.js');
		$view->headScript()->appendFile($view->baseUrl().'/js/custom.js');
		$view->headScript()->appendFile($view->baseUrl().'/js/jquery.circliful.min.js');
		// admin panal js files

                $view->headScript()->appendFile($view->baseUrl().'/js/jquery.js');
                $view->headScript()->appendFile($view->baseUrl().'/js/plugins/morris/raphael.min.js');
                $view->headScript()->appendFile($view->baseUrl().'/js/plugins/morris/morris.min.js');
                $view->headScript()->appendFile($view->baseUrl().'/js/plugins/morris/morris-data.js');
    
    

}
}

