<?php

/** @var array $config */
$config = [
    'me' => 'example@test.com',
    'db' => [
        'dsn' => 'sqlite:db.sqlite',
        'user' => NULL,
        'pass' => NULL,
    ],
    'routes' => [
        '/' => 'posts',
        'post/(\d+)' => 'post',
    ]
];

/**
 * Posts model
 *
 * Retrive all post in database
 * @param int $limit
 * @return mixed
 */
function model_posts($limit = 5) {
    $sql = "SELECT * FROM posts LIMIT " . intVal($limit);
    return db_query($sql);
}

/**
 * Post model
 *
 * Retrive single post info
 * @param int $id
 * @return mixed
 */
function model_post($id = NULL) {
    $sql = "SELECT * FROM posts WHERE id = ?";
    $result = db_query($sql, [$id]);
    return reset($result);
}

/**
 * Posts controller
 *
 * Render page with all posts
 * @return boolean|string
 */
function controller_posts() {
    $model = model_posts(5);
    return view('templates/posts.php', ['posts' => $model]);
}

/**
 * Post controller
 *
 * Render page with a single posts
 * @param int $id
 * @return boolean|string
 */
function controller_post($id = NULL) {
    if ($model = model_post($id)) {
        return view('templates/post.php', [
            'post' => $model,
        ]);
    }
}

/**
 * Static controller
 *
 * Render non dynamic page from html template
 * @return boolean|string
 */
function controller_static() {
    return view('templates/static.php');
}

/**
 * Contact form controller
 *
 * Render contact form and send message on form submit
 * @return boolean|string
 */
function controller_contact() {
    $send = FALSE;

    if (isset($_POST['email'])) {
        $email = helper_get($_POST, 'email', NULL);
        $name = helper_get($_POST, 'name', 'Anon');
        $body = helper_get($_POST, 'message', 'Empty message');

        if ($email !== null) {
            global $config;
            $send = mail($config['me'], 'Message from ' . $name, $body . "\n send from: " . $email);
        }
    }

    return view('templates/contact.php', ['send' => $send]);
}

/**
 * Render php template
 *
 * @param string $template
 * @param array $variables
 * @return string
 */
function view($template, Array $variables = array()) {
    ob_start();

    extract($variables);
    include $template;

    return ob_get_clean();
}

/**
 * Execute database query
 *
 * @param string $sql
 * @param array $params
 * @return mixed
 */
function db_query($sql, Array $params = array()) {
    global $config;
    
    if ( ! isset($config['db']['_instance'])) {
        $config['db']['_instance'] = new \PDO(
            $config['db']['dsn'],
            $config['db']['user'],
            $config['db']['pass']
        );
    }

    $db = $config['db']['_instance'];

    helper_error($db);

    $query = $db->prepare($sql);
    helper_error($query);
    
    $query->execute($params);
    return $query->fetchAll();
}

/**
 * Helper to find array values
 *
 * @param array $arr
 * @param mixed $key
 * @param mixed $default
 * @return mixed
 */
function helper_get($arr, $key, $default = NULL) {
    return (isset($arr[$key]) ? $arr[$key] : $default);
}

/**
 * Error helper
 *
 * @param mixed $var
 * @return void
 */
function helper_error($var) {
    if (!$var) error();
}

/**
 * Error handler
 *
 * @return void
 */
function error() {
    echo view('templates/404.php');
    die();
}

/**
 * Request dispatcher
 *
 * @return void
 */
function dispatch() {
    $result = FALSE;
    $uri = helper_get($_GET, 'page', '/');
    global $config;

    $controller = 'controller_' . $uri;
    if (function_exists($controller)) {
        $result = $controller();
    } else {
        foreach ($config['routes'] as $rule => $controller) {
            $rule = '#^' . rtrim($rule, '/') . '/?$#ui';
            if (preg_match($rule, $uri, $matches)) { 
                $controller = 'controller_' . $controller;           
                $result = call_user_func_array($controller, array_slice($matches, 1));
            }
        }
    }

    if ($result) {
        echo $result;
    } else {
        error();
    }
}

dispatch();
