<?php
use Phalcon\Mvc\Controller;

class LayoutsController extends ControllerBase
{

    public function indexAction()
    {
    	$this->assets
            ->addCss('css/bootstrap')
            ->addCss('css/bootstrap.min.css')
            ->addCss('css/DropdownMultiNivel.css')
            ->addCss('css/loginEstilo.css')
            ->addCss('css/jquery-ui.css')
            ->addCss('css/jquery-ui.min.css');
            
    	$this->assets
            ->addJs('//js/jquery-1.8.3.min.js')
            ->addJs('js/jquery.js')
            ->addJs('js/jquery-ui.js')
            ->addJs('js/jquery-ui.min.js')
            ->addJs('js/bootstrap.min.js');
    }


}
