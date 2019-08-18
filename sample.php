<?php
use LibraryLoaderAutoloader;
use LibraryDatabase\PdoAdapter;
use ModelMapper\UserMapper;
use ModelMapper\CommentMapper;
use ModelMapper\PostMapper;

require_once __DIR__ . "/Autoloader.php";
$autoloader = new Autoloader();
$autoloader->register();

// create a PDO adapter
$adapter = new PdoAdapter("mysql:dbname=blog", "myfancyusername",
    "myhardtoguesspassword");

// create the mappers
$userMapper = new UserMapper($adapter);
$commentMapper = new CommentMapper($adapter, $userMapper);
$postMapper = new PostMapper($adapter, $commentMapper);


$postMapper->insert(
    new Post(
        "Welcome to SitePoint",
        "To become yourself a true PHP master, you must first master PHP."));

$postMapper->insert(
    new Post(
        "Welcome to SitePoint (Reprise)",
        "To become yourself a PHP Master, you must first master... Wait! Did I post that already?"));


$user = new User("Everchanging Joe", "joe@example.com");
$userMapper->insert($user);

// Joe's comments for the first post (post ID = 1, user ID = 1)
$commentMapper->insert(
    new Comment(
        "I just love this post! Looking forward to seeing more of this stuff.",
        $user),
    1, $user->id);

$commentMapper->insert(
    new Comment(
        "I just changed my mind and dislike this post! Hope not seeing more of this stuff.",
        $user),
    1, $user->id);

// Joe's comment for the second post (post ID = 2, user ID = 1)
$commentMapper->insert(
    new Comment(
        "Not quite sure if I like this post or not, so I cannot say anything for now.",
        $user),
    2, $user->id);