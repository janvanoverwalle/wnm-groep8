<?php
/**
 * Created by PhpStorm.
 * User: Timothy Vanderaerden
 * Date: 7/10/16
 * Time: 16:05
 */

//header('Content-Type: application/json');

require 'autoload.php';
require __DIR__ . '/vendor/altorouter/altorouter/AltoRouter.php';
include __DIR__ . '/src/config/router.php';

use \model\PDOUserRepository;
use \model\PDOHabitRepository;
use \view\UserJsonView;
use \view\HabitJsonView;
use \controller\UserController;
use \controller\HabitController;

$user = 'pxlstudent';
$password = 'd92VLSdByYerXRsq';
$host = '149.210.145.131';
$database = '3habits';
$pdo = null;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,
                       PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo 'cannot connect to database';
}

$userPDORepository = new PDOUserRepository($pdo);
$userJsonView = new UserJsonView();
$userController = new UserController($userPDORepository, $userJsonView);

$habitPDORepository = new PDOHabitRepository($pdo);
$habitJsonView = new HabitJsonView();
$habitController = new HabitController($habitPDORepository, $habitJsonView);

/**
 * @GET
 * @route = users/id
 * @return user + habits
 */
$router->map('GET', '/users/[i:id]', function ($id) use (&$userController) {
	$userController->handleFindUserById($id);
});

/**
 * @POST
 * @route = users
 * @return user
 * @description Nieuwe gebruiker zonder 'id' op te geven
 */
$router->map('POST', '/users/', function () use (&$userController) {
    //Get json objects
    $requestBody = file_get_contents('php://input');
    $data = json_decode($requestBody);

    // variable declaration
    $user = $data[0]->user;

    $userController->handleInsertUser($user);
});

/**
 * @GET
 * @route = users
 * @return all users
 */
$router->map('GET', '/users/', function () use (&$userController) {
    $userController->handleFindAllUsers();
});

/**
 * @GET
 * @route = habits/id
 * @return habits + users
 */
$router->map('GET', '/habits/[i:id]', function ($id) {
    // SELECT habits + users
    $sth = Database::get()->prepare("SELECT u.*, h.description FROM user_habits uh 
                                    JOIN user u ON u.id=uh.user_id 
                                    JOIN habit h ON uh.habit_id=h.id 
                                    WHERE uh.habit_id = :id");
    $sth->bindParam(':id', $id);
    $sth->execute();
    $habit_users = $sth->fetchAll(PDO::FETCH_ASSOC);

    // variable declaration
    $habitUsersList = array();
    $habit = new Habit($id, $habit_users[0]['description']);

    // json object (User)
    foreach ($habit_users as $user) {
        $u = new User($user['id'], $user['name']);
        $habitUsersList[] = $u->expose();
    }

    // prepare json object ('habit' = Habit, 'users' = array(User))
    $json_array = array("habit" => $habit->expose(), "users" => $habitUsersList);

    // encode in json + return
    echo json_encode(array($json_array));
});

/**
 * @GET
 * @route = habits
 * @return all habits
 */
$router->map('GET', '/habits/', function () use (&$habitController)  {
    $habitController->handleFindAllHabits();
});

$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    // no route was matched
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}