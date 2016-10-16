<?php
/**
 * Created by PhpStorm.
 * User: Timothy Vanderaerden
 * Date: 7/10/16
 * Time: 16:05
 */

header('Content-Type: application/json');

require __DIR__ . '/vendor/altorouter/altorouter/AltoRouter.php';
include __DIR__ . '/src/config/router.php';

include_once __DIR__ . '/src/controller/UserController.php';
include_once __DIR__ . '/src/controller/HabitController.php';

include_once __DIR__ . '/src/view/JsonView.php';


/**
 * @GET
 * @route = users/id
 * @return user + habits
 */
$router->map('GET', '/users/[i:id]', function ($id) {
	/*
    // SELECT user + 3habits
    $sth = Database::get()->prepare("SELECT u.name, h.id, h.description FROM user_habits uh 
                                    JOIN user u ON u.id=uh.user_id 
                                    JOIN habit h ON uh.habit_id=h.id 
                                    WHERE uh.user_id = :id ");
    $sth->bindParam(':id', $id);
    $sth->execute();
    $user_habits = $sth->fetchAll(PDO::FETCH_ASSOC);

    // variable declaration
    $name = $user_habits[0]['name'];
    $user = new User($id, $name);
    $habits = array();

    // get all 3 habits
    foreach ($user_habits as $habit) {
        $h = new Habit($habit['id'], $habit['description']);
        $habits[] = $h->expose();
    }

    // prepare json object ('user' = User, 'habits' = array(Habit))
    $json_array = array("user" => $user->expose(), "habits" => $habits);
	*/

	$user = UserController::findUserById($id);
	//$habits = HabitController::findHabitsByUserId($id);
	//$habits_reached = HabitController::findHabitsReachedByUserId($id);
	
    // pass to view
    JsonView::show($user);
});

/**
 * @POST
 * @route = users
 * @return user
 * @description Nieuwe gebruiker zonder 'id' op te geven
 */
$router->map('POST', '/users/', function () {
    //Get json objects
    $requestBody = file_get_contents('php://input');
    $users = json_decode($requestBody);

    // variable declaration
    $name = $users[0]->user->name;

    $user = UserController::insertUser($name);
	
	if ($user != null) {
		JsonView::show($user);
	}
});

/**
 * @GET
 * @route = users
 * @return all users
 */
$router->map('GET', '/users/', function () {
    $users = UserController::findAllUsers();

    JsonView::show($users);
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
$router->map('GET', '/habits/', function () {
    $habits = HabitController::findAllHabits();

    JsonView::show($habits);
});

$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    // no route was matched
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}