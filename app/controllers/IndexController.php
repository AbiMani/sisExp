<?php
use Phalcon\Mvc\Controller;

class IndexController extends ControllerBase
{

    
    
    public function indexAction()
    {
    	
            
    	$this->assets
            ->addJs('//js/jquery-1.8.3.min.js')
            ->addJs('js/jquery.js')
            ->addJs('js/jquery-ui.js')
            ->addJs('js/jquery-ui.min.js')
            ->addJs('js/bootstrap.min.js');
    }


}

