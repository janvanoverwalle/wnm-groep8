<?php
/**
 * Created by PhpStorm.
 * User: Timothy Vanderaerden
 * Date: 7/10/16
 * Time: 16:05
 */

require __DIR__ . '/vendor/altorouter/altorouter/AltoRouter.php';
include __DIR__ . '/config.php';

$router->map('GET','/users/[i:id]', 'users#show', 'users_show');

$match = $router->match();
?>
<h1>AltoRouter</h1>

<h3>Current request: </h3>
<pre>
	Target: <?php var_dump($match['target']); ?>
    Params: <?php var_dump($match['params']); ?>
    Name: 	<?php var_dump($match['name']); ?>
</pre>
