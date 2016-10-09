<?php
/**
 * Created by PhpStorm.
 * User: Timothy Vanderaerden
 * Date: 7/10/16
 * Time: 16:05
 */

require __DIR__ . '/vendor/altorouter/altorouter/AltoRouter.php';
require __DIR__ . '/Database.php';
include __DIR__ . '/config.php';

$router->map('GET', '/users/[i:id]', function ($id) {
    // SELECT user + 3habits
    $sth = Database::get()->prepare("SELECT u.name, h.description FROM user_habits uh 
                                    JOIN user u ON u.id=uh.user_id 
                                    JOIN habit h ON uh.habit_id=h.id 
                                    WHERE uh.user_id = :id ");
    $sth->bindParam(':id', $id);
    $sth->execute();
    $user_habits = $sth->fetchAll(PDO::FETCH_ASSOC);

    // variable declaration
    $name = $user_habits[0]['name'];
    $habits = array();

    // get all 3 habits
    foreach ($user_habits as $d) {
        $habits[] .= $d['description'];
    }

    // prepare json object ('name' = string, 'habits' = array(string))
    $json_array = array("name"=>$name, "habits"=>$habits);

    // encode in json + return
    echo json_encode($json_array);
});

$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    // no route was matched
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    echo '404';
}
?>