<?php 
 
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl;
 
/*
* plugin roles para llevar a cabo roles de usuarios en Phalcon
*/
class Roles extends Plugin
{
 /**
 * lógica para crear una aplicación con roles de usuarios
 */
 	public function getAcl()
 	{
 		if (!isset($this->persistent->acl)) 
 		{
 		//creamos la instancia de acl para crear los roles
 			$acl = new Phalcon\Acl\Adapter\Memory();
 
	 		//por defecto la acción será denegar el acceso a cualquier zona
	 		$acl->setDefaultAction(Phalcon\Acl::DENY);
	 
	 		//registramos los roles que deseamos tener en nuestra aplicación
 			$roles = array(
				 'admin' => new Phalcon\Acl\Role('Admin'),
				 'registered' => new Phalcon\Acl\Role('Registered'),
				 'guest' => new Phalcon\Acl\Role('Guest')
			 );
 
			 //añadimos los roles al acl
			 foreach ($roles as $role) 
			 {
			 	$acl->addRole($role);
			 }
 
			 //zonas accesibles sólo para role admin
			 $adminAreas = array(
			 	'admin' => array('index', 'save')
			 );
 
			 //añadimos las zonas de administrador a los recursos de la aplicación
			 foreach ($adminAreas as $resource => $actions) 
			 {
			 	$acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
			 }
 
			 //zonas protegidas sólo para usuarios registrados de la aplicación
			 $registeredAreas = array(
				 'dashboard' => array('index'),
				 'profile' => array('index', 'edit')
			 );
 
			 //añadimos las zonas para usuarios registrados a los recursos de la aplicación
			 foreach ($registeredAreas as $resource => $actions) 
			 {
			 	$acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
			 }
 
			 //zonas públicas de la aplicación
			 $publicAreas = array(
			 	'index' => array('index', 'register', 'login', 'end')
			 );
 
			 //añadimos las zonas públicas a los recursos de la aplicación
			 foreach ($publicAreas as $resource => $actions) 
			 {
			 	$acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
			 }
 
			 //damos acceso a todos los usuarios a las zonas públicas de la aplicación
			 foreach ($roles as $role) 
			 {
			 	foreach ($publicAreas as $resource => $actions) 
			 	{
			 		$acl->allow($role->getName(), $resource, '*');
			 	}
			 }
 
			 //damos acceso a la zona de admins solo a rol Admin
			 foreach ($adminAreas as $resource => $actions) 
			 {
			 	foreach ($actions as $action)
			 	{
			 		$acl->allow('Admin', $resource, $action);
			 	}
			 }
 
			 //damos acceso a las zonas de registro tanto a los usuarios
			 //registrados como al admin
			 foreach ($registeredAreas as $resource => $actions) 
			 {
				//damos acceso a los registrados
				foreach ($actions as $action)
			 	{
			 		$acl->allow('Registered', $resource, $action);
			 	}
				 //damos acceso al admin
				foreach ($actions as $action)
				{
					$acl->allow('Admin', $resource, $action);
				}
			}
 
		//El acl queda almacenado en sesión
		$this->persistent->acl = $acl;
		}
			 
		return $this->persistent->acl;
	}
 
			 /**
			 * Esta acción se ejecuta antes de ejecutar cualquier acción en la aplicación
			 */
	public function beforeDispatch(Event $event, Dispatcher $dispatcher)
	{
			 
	//esta sesión sólo la tendrá el admin
		$admin = $this->session->get('admin');

		//esta sesión sólo la tendrá el usuario registrado
		$registered = $this->session->get('registered');
 
		//si no es admin ni un usuario registrado es guest
		if (!$admin && !$registered)
		{
			$role = 'Guest';
		} 
		//si es admin
		else if($admin)
		{
			$role = 'Admin';
		}
		//en otro caso es un usuario registrado
		else
		{
			$role = 'Registered';
		}
 
		//nombre del controlador al que intentamos acceder
		$controller = $dispatcher->getControllerName();
				 
		//nombre de la acción a la que intentamos acceder
		$action = $dispatcher->getActionName();
				 
		//obtenemos la Lista de Control de Acceso(acl) que hemos creado
		$acl = $this->getAcl();
				 
		//boolean(true | false) si tenemos permisos devuelve true en otro caso false
		$allowed = $acl->isAllowed($role, $controller, $action);
				 
		//si el usuario no tiene acceso a la zona que intenta acceder
		//le mostramos el contenido de la función index del controlador index
		//con un mensaje flash
		if ($allowed != Acl::ALLOW) 
		{
			$this->flash->error("Zona restringida, no puedes entrar aquí!");
			$dispatcher->forward(
			array(
				'controller' => 'index',
				'action' => 'index'
			)
			);
		return false;
		}
 	}
}