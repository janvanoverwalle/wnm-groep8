<?php
/**
 * Created by PhpStorm.
 * User: Timothy Vanderaerden
 * Date: 7/10/16
 * Time: 16:05
 */

header('access-control-allow-origin: *');

require 'autoload.php';
require 'vendor/autoload.php';
require __DIR__ . '/vendor/altorouter/altorouter/AltoRouter.php';
include __DIR__ . '/src/config/router.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use \model\PDOUserRepository;
use \model\PDOHabitRepository;
use \model\PDOCaloriesRepository;
use \model\PDOWeightRepository;
use \view\UserJsonView;
use \view\HabitJsonView;
use \view\CaloriesJsonView;
use \view\WeightJsonView;
use \controller\UserController;
use \controller\HabitController;
use \controller\CaloriesController;
use \controller\WeightController;

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

$weightPDORepository = new PDOWeightRepository($pdo);
$weightJsonView = new WeightJsonView();
$weightController = new WeightController($weightPDORepository, $weightJsonView);

$log = new Logger('api');
$log->pushHandler(new StreamHandler(__DIR__ . '/log.txt', Logger::INFO));

/********* GET *********/

/**
 * @GET
 * @route = users/id
 * @return user
 */
$router->map('GET', '/users/[i:id]/?', function ($id) use (&$userController, &$log) {
	$log->info('GET user by id : '.$id);
    $userController->handleFindUserById($id);
});

/**
 * @GET
 * @route = users/name
 * @return user
 */
$router->map('GET', '/users/[a:username]/?', function ($username) use (&$userController, &$log) {
	$log->info('GET user by username : '.$username);
    $userController->handleFindUserByUsername($username);
});

/**
 * @GET
 * @route = users/id/habits
 * @return user + his habits
 */
$router->map('GET', '/users/[i:id]/habits/?', function ($id) use (&$habitController, &$log) {
	$log->info('GET user habits by user_id : '.$id);
    $habitController->handleFindHabitsByUserId($id);
});

/**
 * @GET
 * @route = users/id/habits/id
 * @return user + habit
 */
$router->map('GET', '/users/[i:uid]/habits/[i:hid]/?', function ($uid, $hid) use (&$habitController, &$log) {
    $log->info('GET user habit by user_id : '.$uid.' and habit_id : '.$hid);
	$habitController->handleFindHabitByIdAndUserId($hid, $uid);
});

/**
 * @GET
 * @route = users/id/calories
 * @return users + his calories
 */
$router->map('GET', '/users/[i:id]/calories/?', function ($id) use (&$caloriesController, &$log) {
	$log->info('GET user calories by user_id : '.$id);
    $caloriesController->handleFindCaloriesByUserId($id);
});

/**
 * @GET
 * @route = users/id/calories/id
 * @return user + calorie
 */
$router->map('GET', '/users/[i:uid]/calories/[i:cid]/?', function ($uid, $cid) use (&$caloriesController, &$log) {
    $log->info('GET user calorie by user_id : '.$uid.' and calorie_id : '.$cid);
	$caloriesController->handleFindCaloriesByIdAndUserId($cid, $uid);
});

/**
 * @GET
 * @route = users/id/weights
 * @return users + his calories
 */
$router->map('GET', '/users/[i:id]/weights/?', function ($id) use (&$weightController, &$log) {
	$log->info('GET user weights by user_id : '.$id);
    $weightController->handleFindWeightsByUserId($id);
});

/**
 * @GET
 * @route = users/id/weights/id
 * @return user + weight
 */
$router->map('GET', '/users/[i:uid]/weights/[i:wid]/?', function ($uid, $wid) use (&$weightController, &$log) {
	$log->info('GET user weight by user_id : '.$uid.' and weight_id'.$wid);
    $weightController->handleFindWeightByIdAndUserId($wid, $uid);
});

/**
 * @GET
 * @route = habit_reached
 * @return habit_reached from users
 */
$router->map('GET', '/users/[i:uid]/habits/status/?', function ($uid) use (&$habitController, &$log) {
    $log->info('GET user daily habit status by user_id : '.$uid);
    $habitController->handleFindHabitsReachedByUserId($uid);
});

/**
 * @GET
 * @route = users
 * @return all users
 */
$router->map('GET', '/users/?', function () use (&$userController, &$log) {
	$log->info('GET all users');
    $userController->handleFindAllUsers();
});

/**
 * @GET
 * @route = habits/id
 * @return habits
 */
$router->map('GET', '/habits/[i:id]/?', function ($id) use (&$habitController, &$log) {
	$log->info('GET habits by id : '.$id);
    $habitController->handleFindHabitById($id);
});

/**
 * @GET
 * @route = habits
 * @return all habits
 */
$router->map('GET', '/habits/?', function () use (&$habitController, &$log) {
	$log->info('GET all habits');
    $habitController->handleFindAllHabits();
});

/**
 * @GET
 * @route = calories/id
 * @return calories
 */
$router->map('GET', '/calories/[i:id]/?', function ($id) use (&$caloriesController, &$log) {
	$log->info('GET calories by id : '.$id);
    $caloriesController->handleFindCaloriesById($id);
});

/**
 * @GET
 * @route = calories
 * @return all calories
 */
$router->map('GET', '/calories/?', function () use (&$caloriesController, &$log) {
	$log->info('GET all calories');
    $caloriesController->handleFindAllCalories();
});

/**
 * @GET
 * @route = weight/id
 * @return weight
 */
$router->map('GET', '/weights/[i:id]/?', function ($id) use (&$weightController, &$log) {
	$log->info('GET weights by id : '.$id);
    $weightController->handleFindWeightById($id);
});

/**
 * @GET
 * @route = weight
 * @return all weight
 */
$router->map('GET', '/weights/?', function () use (&$weightController, &$log) {
	$log->info('GET all weights');
    $weightController->handleFindAllWeights();
});

/********* POST *********/

/**
 * @POST
 * @route = users
 * @return user
 * @description Nieuwe gebruiker zonder 'id' op te geven
 */
$router->map('POST', '/users/?', function () use (&$userController) {
    // Get json objects
	// [{"user" : {"name" : "user_name"}}]
    $requestBody = file_get_contents('php://input');
    $data = (array)json_decode($requestBody);

    // variable declaration
    $user = new User();
    $user->unserializeJson($data[0]->user);

    $userController->handleInsertUser($user);
});

/**
 * @POST
 * @route = habits
 * @return habit
 * @description Nieuwe habit zonder 'id' op te geven
 */
$router->map('POST', '/habits/?', function () use (&$habitController) {
    // Get json objects
	// [{"habit" : {"description" : "habit_description"}}]
    $requestBody = file_get_contents('php://input');
    $data = (array)json_decode($requestBody);

    // variable declaration
    $habit = $data[0]->habit;

    $habitController->handleInsertHabit($habit->description);
});

/**
 * @POST
 * @route = users/id/habits
 * @return habit
 * @description New user habit relation
 */
$router->map('POST', '/users/[i:id]/habits/?', function ($id) use (&$habitController) {
    // Get json objects
	// [{"habit" : {"id" : "habit_id"}}]
    $requestBody = file_get_contents('php://input');
    $data = (array)json_decode($requestBody);

    // variable declaration
	$habit = $data[0]->habit;

    $habitController->handleInsertUserHabit($id, $habit->id);
});

/**
 * @POST
 * @route = calories
 * @return calories
 * @description Nieuwe calories zonder 'id' op te geven
 */
$router->map('POST', '/calories/?', function () use (&$caloriesController) {
    // Get json objects
    // [{"calories":{"calories":"...", "date":"2016-10-16", "user_id":"..."}}]
    $requestBody = file_get_contents('php://input');
    $data = (array)json_decode($requestBody);

    // variable declaration
    $calories = $data[0]->calories;

    $caloriesController->handleInsertCalories($calories);
});

/**
 * @POST
 * @route = weights
 * @return weight
 * @description Nieuwe weight zonder 'id' op te geven
 */
$router->map('POST', '/weights/?', function () use (&$weightController) {
    // Get json objects
    // [{"weight":{"weight":"...", "date":"2016-10-16", "user_id":"..."}}]
    $requestBody = file_get_contents('php://input');
    $data = (array)json_decode($requestBody);

    // variable declaration
    $weight = $data[0]->weight;

    $weightController->handleInsertWeight($weight);
});

/********* DELETE *********/

/**
 * @DELETE
 * @route = users/id
 * @return user
 * @description Verwijder gebruiker met 'id'
 */
$router->map('DELETE', '/users/[i:id]/?', function ($id) use (&$userController) {
    $userController->handleDeleteUserById($id);
});

/**
 * @DELETE
 * @route = habits/id
 * @return habit
 * @description Verwijder habit met 'id'
 */
$router->map('DELETE', '/habits/[i:id]/?', function ($id) use (&$habitController) {
    $habitController->handleDeleteHabitById($id);
});

/**
 * @DELETE
 * @route = users/id/habits/id
 * @return habit
 * @description Verwijder user habit met 'user_id' en 'habit_id'
 */
$router->map('DELETE', '/users/[i:uid]/habits/[i:hid]/?', function ($hid, $uid) use (&$habitController) {
    $habitController->handleDeleteHabitByIdAndUserId($hid, $uid);
});

/**
 * @DELETE
 * @route = calories/id
 * @return calories
 * @description Verwijder calories met 'id'
 */
$router->map('DELETE', '/calories/[i:id]/?', function ($id) use (&$caloriesController) {
    $caloriesController->handleDeleteCaloriesById($id);
});

/**
 * @DELETE
 * @route = weights/id
 * @return weight
 * @description Verwijder weights met 'id'
 */
$router->map('DELETE', '/weights/[i:id]/?', function ($id) use (&$weightController) {
    $weightController->handleDeleteWeightById($id);
});

/********* PUT *********/

/**
 * @PUT
 * @route = users
 * @return user
 * @description Update gebruiker zonder 'id' op te geven
 */
$router->map('PUT', '/users/?', function () use (&$userController) {
    // Get json objects
	// [{"user" : {"id" : "user_id", "name" : "user_name"}}]
    $requestBody = file_get_contents('php://input');
    $data = (array)json_decode($requestBody);

    // variable declaration
    $user = new User();
    $user->unserializeJson($data[0]->user);

    $userController->handleUpdateUserById($user);
});

/**
 * @PUT
 * @route = habits
 * @return habit
 * @description Update habit
 */
$router->map('PUT', '/habits/?', function () use (&$habitController) {
    // Get json objects
	// [{"habit" : {"id" : "habit_id", "description" : "habit_description"}}]
    $requestBody = file_get_contents('php://input');
    $data = (array)json_decode($requestBody);

    // variable declaration
    $habit = $data[0]->habit;

    $habitController->handleUpdateHabitById($habit);
});

/**
 * @PUT
 * @route = users/id/habits
 * @return habit
 * @description Update user habit
 */
$router->map('PUT', '/users/[i:id]/habits/?', function ($id) use (&$habitController) {
    // Get json objects
	// [{"habit" : {"oldId" : "habit_id", "newId" : "habit_id"}}]
    $requestBody = file_get_contents('php://input');
    $data = (array)json_decode($requestBody);

    // variable declaration
    $habit = $data[0]->habit;

    $habitController->handleUpdateHabitByIdAndUserId($id, $habit->oldId, $habit->newId);
});

/**
 * @PUT
 * @route = calories
 * @return calories
 * @description UPDATE calories
 */
$router->map('PUT', '/calories/?', function () use (&$caloriesController) {
    // Get json objects
    // [{"calories":{"calories":"...", "date":"2016-10-16"}}]
    $requestBody = file_get_contents('php://input');
    $data = (array)json_decode($requestBody);

    // variable declaration
    $calorie = $data[0]->calories;

    $caloriesController->handleUpdateCaloriesById($calorie);
});

/**
 * @PUT
 * @route = weights
 * @return weight
 * @description UPDATE weights
 */
$router->map('PUT', '/weights/?', function () use (&$weightController) {
    // Get json objects
    // [{"weight":{"id":"", "weight":"...", "date":"2016-10-16"}}]
    $requestBody = file_get_contents('php://input');
    $data = (array)json_decode($requestBody);

    // variable declaration
    $weight = $data[0]->weight;

    $weightController->handleUpdateWeightById($weight);
});

$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    // no route was matched
	header('Content-Type: application/json');
    //header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    echo "{}";
}