<?php

class UsersController extends ControllerBase
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

    public function createAction(){
    	$user = new Users();
        // Store and check for errors
        $success = $user->save(
            $this->request->getPost(),
            [
                "correo",
                "contraseña",
            ]
        );
        if ($success) {
            echo "Thanks you for signing up!";
        } else {
            echo "Oops, seems like the following issues were encountered: ";
            $messages = $user->getMessages();
            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }
        $this->view->disable();

    }

        public function loginAction()
    {
        if ($this->request->isPost()) {
            $user = Users::findFirst(array(
                'login = :login: and password = :password:',
                'bind' => array(
                    'login' => $this->request->getPost("login"),
                    'password' => sha1($this->request->getPost("password"))
                )
            ));
            if ($user === false){
                $this->flash->error("Incorrect credentials");
                return $this->dispatcher->forward(array(
                    'controller' => 'users',
                    'action' => 'index'
                ));
            }
            $this->session->set('auth', $user->id);
            $this->flash->success("You've been successfully logged in");
        }
        return $this->dispatcher->forward(array(
            'controller' => 'posts',
            'action' => 'index'
        ));
    }

    public function logoutAction()
    {
        $this->session->remove('auth');
        return $this->dispatcher->forward(array(
            'controller' => 'posts',
            'action' => 'index'
        ));
    }


}

