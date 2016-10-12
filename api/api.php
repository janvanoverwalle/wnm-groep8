<?php
/**
 * Created by PhpStorm.
 * User: Timothy Vanderaerden
 * Date: 7/10/16
 * Time: 16:05
 */

header('Content-Type: application/json');

require __DIR__ . '/vendor/altorouter/altorouter/AltoRouter.php';
require __DIR__ . '/config/Database.php';
include __DIR__ . '/config/router.php';
include __DIR__ . '/models/User.php';
include __DIR__ . '/models/Habit.php';

/**
 * @route = users/id
 * @return user + habits
 */
$router->map('GET', '/users/[i:id]', function ($id) {
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

    // encode in json + return
    echo json_encode(array($json_array));
});

/**
 * @route = users
 * @return all users
 */
$router->map('GET', '/users', function () {
    // SELECT users
    $sth = Database::get()->prepare("SELECT * FROM user");
    $sth->execute();
    $users = $sth->fetchAll(PDO::FETCH_ASSOC);

    // variable declaration
    $userList = array();

    // json object (User)
    foreach ($users as $user) {
        $u = new User($user['id'], $user['name']);
        $userList[] = $u->expose();
    }

    // encode in json + return
    echo json_encode($userList);
});

/**
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
    echo json_encode($json_array);
});

/**
 * @route = habits
 * @return all habits
 */
$router->map('GET', '/habits', function () {
    // SELECT habits
    $sth = Database::get()->prepare("SELECT * FROM habit");
    $sth->execute();
    $habits = $sth->fetchAll(PDO::FETCH_ASSOC);

    // variable declaration
    $habitList = array();

    // json object (User)
    foreach ($habits as $habit) {
        $h = new Habit($habit['id'], $habit['description']);
        $habitList[] = $h->expose();
    }

    // encode in json + return
    echo json_encode($habitList);
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