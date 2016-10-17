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
use \model\PDOCaloriesRepository;
use \view\UserJsonView;
use \view\HabitJsonView;
use \view\CaloriesJsonView;
use \controller\UserController;
use \controller\HabitController;
use \controller\CaloriesController;

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

$caloriesPDORepository = new PDOCaloriesRepository($pdo);
$caloriesJsonView = new CaloriesJsonView();
$caloriesController = new CaloriesController($caloriesPDORepository, $caloriesJsonView);

/**
 * @GET
 * @route = users/id
 * @return user + habits
 */
$router->map('GET', '/users/[i:id]/?', function ($id) use (&$userController) {
	$userController->handleFindUserById($id);
});

/**
 * @GET
 * @route = users/id/habits
 * @return user + his habits
 */
$router->map('GET', '/users/[i:id]/habits/?', function ($id) use (&$habitController) {
	$habitController->handleFindHabitsByUserId($id);
});

/**
 * @GET
 * @route = users/id/habits/id
 * @return user + habit
 */
$router->map('GET', '/users/[i:uid]/habits/[i:hid]/?', function ($uid, $hid) use (&$habitController) {
	$habitController->handleFindHabitByIdAndUserId($hid, $uid);
});

/**
 * @GET
 * @route = users/id/calories
 * @return users + his calories
 */
$router->map('GET', '/users/[i:id]/calories/?', function ($id) use (&$caloriesController) {
    $caloriesController->handleFindCaloriesByUserId($id);
});

/**
 * @GET
 * @route = users/id/calories/id
 * @return user + calorie
 */
$router->map('GET', '/users/[i:uid]/calories/[i:cid]/?', function ($uid, $cid) use (&$caloriesController) {
    $caloriesController->handleFindCaloriesByIdAndUserId($cid, $uid);
});

/**
 * @POST
 * @route = users
 * @return user
 * @description Nieuwe gebruiker zonder 'id' op te geven
 */
$router->map('POST', '/users/?', function () use (&$userController) {
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
$router->map('GET', '/users/?', function () use (&$userController) {
    $userController->handleFindAllUsers();
});

/**
 * @GET
 * @route = habits/id
 * @return habits
 */
$router->map('GET', '/habits/[i:id]/?', function ($id) use (&$habitController) {
    $habitController->handleFindHabitById($id);
});

/**
 * @GET
 * @route = habits
 * @return all habits
 */
$router->map('GET', '/habits/?', function () use (&$habitController) {
    $habitController->handleFindAllHabits();
});

/**
 * @GET
 * @route = calories/id
 * @return calories
 */
$router->map('GET', '/calories/[i:id]/?', function ($id) use (&$caloriesController) {
    $caloriesController->handleFindCaloriesById($id);
});

/**
 * @GET
 * @route = calories
 * @return all calories
 */
$router->map('GET', '/calories/?', function () use (&$caloriesController) {
    $caloriesController->handleFindAllCalories();
});

$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    // no route was matched
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
	echo "404 - Not Found";
}