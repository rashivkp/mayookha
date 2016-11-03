<?php

use Silex\Provider\SessionServiceProvider;
use Symfony\Component\HttpFoundation\Request;


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
$app->register(new Silex\Provider\SecurityServiceProvider());

$app['security.firewalls'] = array(
'login' => array(
        'pattern' => '^/login$',
    ),
    'secured' => array(
        'pattern' => '^/admin',
        'form' => array('login_path' => '/login', 'check_path' => '/admin/login_check'),
        'logout' => array('logout_path' => '/admin/logout', 'invalidate_session' => true),
        'users' => array(
        // raw password is foo
        'admin' => array('ROLE_ADMIN', '$2y$10$3i9/lVd8UOFIJ6PAMFt8gu3/r5g0qeCJvoSlLCsvMTythye19F77a'),
        ),
    ),
);

$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
});

$app->get('/', function () use ($app) {
    $sql = "SELECT * FROM departments order by score desc";
    $departments = $app['db']->fetchAll($sql);
    $sql = "SELECT items.id, items.name, result.student_name, result.department_id, result.position, result.semester, departments.name as department_name FROM items
        join result on items.id = result.item_id join departments on result.department_id=departments.id order by result.id";
    $items = $app['db']->fetchAll($sql);
    $sql = "SELECT item_id, count(*) as count from result group by item_id order by id;";
    $itemsCount = $app['db']->fetchAll($sql);
    $positions = array(1=>'First', 2=>'Second', 3=>'Third');
    return $app['twig']->render('index.html', array('departments' => $departments, 'items'=>$items, 'positions'=>$positions, 'itemsCount'=>$itemsCount));
});

$app->get('/admin', function () use ($app) {
    $sql = "SELECT * FROM departments";
    $departments = $app['db']->fetchAll($sql);
    $sql = "SELECT * FROM items";
    $items = $app['db']->fetchAll($sql);
    return $app['twig']->render('update.html', array('items' => $items, 'departments' => $departments));
});

$app->post('/admin', function () use ($app) {

    $itemId = $_POST['item'];
    $sql = "SELECT count(*) as count FROM result where item_id=?";
    $itemExists = $app['db']->fetchAssoc($sql, array((int)$itemId));

    if ($itemExists['count'] > 0) {
        $app['session']->getFlashBag()->add('error', '<br><br>Result already entered.!! ');
        return $app->redirect('/admin', 301);
    }

    $sql = "SELECT * FROM items where id=?";
    $item = $app['db']->fetchAssoc($sql, array((int)$itemId));
    $score = array(1=>5, 2=>3, 3=>2);
    if ($item['is_group'] == 1) {
        $score = array(1=>10, 2=>5, 3=>3);
    }

    foreach(range(1, 3) as $i) {
        $names = $_POST["name$i"];
        $semesters = $_POST["semester$i"];
        $departments = $_POST["department$i"];

        foreach($names as $k=>$name) {
            $semester = $semesters[$k];
            $department = $departments[$k];
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
    }

    $app['session']->getFlashBag()->add('success', 'Updated');
    return $app->redirect('/admin', 301);
});

$app->get('/about', function () use ($app) {
    return $app['twig']->render('about.html');
});

return $app;
