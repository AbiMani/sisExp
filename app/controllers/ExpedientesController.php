<?php

class ExpedientesController extends ControllerBase
{

	public function initialize()
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

    public function indexAction()
    {
    	
    }

    public function saveAction(){
        
    	
    }

}

