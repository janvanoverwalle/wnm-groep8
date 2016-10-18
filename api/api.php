<?php
/**
 * Created by PhpStorm.
 * User: Timothy Vanderaerden
 * Date: 7/10/16
 * Time: 16:05
 */

require 'autoload.php';
require __DIR__ . '/vendor/altorouter/altorouter/AltoRouter.php';
include __DIR__ . '/src/config/router.php';

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

/********* GET *********/

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
 * @GET
 * @route = users/id/weights
 * @return users + his calories
 */
$router->map('GET', '/users/[i:id]/weights/?', function ($id) use (&$weightController) {
    $weightController->handleFindWeightsByUserId($id);
});

/**
 * @GET
 * @route = users/id/weights/id
 * @return user + weight
 */
$router->map('GET', '/users/[i:uid]/weights/[i:wid]/?', function ($uid, $wid) use (&$weightController) {
    $weightController->handleFindWeightByIdAndUserId($wid, $uid);
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

/**
 * @GET
 * @route = weight/id
 * @return weight
 */
$router->map('GET', '/weights/[i:id]/?', function ($id) use (&$weightController) {
    $weightController->handleFindWeightById($id);
});

/**
 * @GET
 * @route = weight
 * @return all weight
 */
$router->map('GET', '/weights/?', function () use (&$weightController) {
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
	// [{"user" : {"name" : "user_name"}"}]
    $requestBody = file_get_contents('php://input');
    $data = (array)json_decode($requestBody);

    // variable declaration
    $user = $data[0]->user;

    $userController->handleInsertUser($user->name);
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
$router->map('DELETE', '/users/[i:uid]/habits/[i:hid]/?', function ($id) use (&$habitController) {
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

    print_r($data);
    // variable declaration
    $user = $data[0]->user;

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
 * @description UPDATE calories zonder 'id' op te geven
 */
$router->map('PUT', '/calories/?', function () use (&$caloriesController) {
    // Get json objects
    // [{"calories":{"calories":"...", "date":"2016-10-16", "user_id":"..."}}]
    $requestBody = file_get_contents('php://input');
    $data = (array)json_decode($requestBody);

    // variable declaration
    $calorie = $data[0]->calories;

    $caloriesController->handleUpdateCaloriesById($calorie);
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