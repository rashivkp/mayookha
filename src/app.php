<?php

use Silex\Provider\SessionServiceProvider;
//use Silex\Provider\FormServiceProvider;


require_once __DIR__.'/../vendor/autoload.php';
$config = require __DIR__.'/config.php';

$app = new Silex\Application();
$app['debug'] = true;

// DB
$app->register(new Silex\Provider\DoctrineServiceProvider(), $config);

// session
$app->register(new SessionServiceProvider());

// Twig
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path'       => __DIR__.'/../views',
    'twig.class_path' => __DIR__.'/../vendor/twig/lib',
    'twig.options' => array('cache' => __DIR__.'/../cache'),
));
//$app->register(new FormServiceProvider());

$app->get('/', function () use ($app) {
    $sql = "SELECT * FROM departments order by score desc";
    $departments = $app['db']->fetchAll($sql);
    $sql = "SELECT items.id, items.name, result.student_name, result.department_id, result.position, result.semester, departments.name as department_name FROM items
        join result on items.id = result.item_id join departments on result.department_id=departments.id order by result.id";
    $items = $app['db']->fetchAll($sql);
    return $app['twig']->render('index.html', array('departments' => $departments, 'items'=>$items));
});

$app->get('/update', function () use ($app) {
    $sql = "SELECT * FROM departments";
    $departments = $app['db']->fetchAll($sql);
    $sql = "SELECT * FROM items";
    $items = $app['db']->fetchAll($sql);
    return $app['twig']->render('update.html', array('items' => $items, 'departments' => $departments));
});

$app->post('/update', function () use ($app) {

    $itemId = $_POST['item'];
    $sql = "SELECT * FROM items where id=?";
    $item = $app['db']->fetchAssoc($sql, array((int)$itemId));
    $score = array(1=>5, 2=>3, 3=>2);
    if ($item['is_group'] == 1) {
        $score = array(1=>10, 2=>5, 3=>3);
    }

    foreach(range(1, 3) as $i) {
        $name = $_POST["name$i"];
        $semester = $_POST["semester$i"];
        $department = $_POST["department$i"];

        if($name == '') {
            continue;
        }

        $sql = "INSERT INTO `result` (
            `item_id` ,
            `student_name` ,
            `department_id` ,
            `semester` ,
            `position`
        )
        VALUES (
            $itemId,
            '$name',
            $department,
            $semester,
            $i
        );";
        $app['db']->executeUpdate($sql);

        // update score
        $sql = "update `departments` set score = score + $score[$i] where id=?;";
        $app['db']->executeUpdate($sql, array((int)$department));
    }

    $app['session']->getFlashBag()->add('success', 'Updated');
    return $app->redirect('/update', 301);
});


return $app;
