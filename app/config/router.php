<?php

$router = $di->getRouter();

// Define your routes here

$router->handle();

$router->add("/expedientes",
	array(
		'controller' => 'expedientes',
		'action' => 'save'
	)
);

$router->add("/users",
	array(
		'controller' => 'users',
		'action' => 'create'
	)
);

return $router;