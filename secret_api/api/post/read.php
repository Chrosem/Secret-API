<?php

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Post.php';


  $database = new Database();
  $db = $database->connect();

  $post = new Post($db);


  $post->secret_hash = isset($_GET['secret_hash']) ? $_GET['secret_hash'] : die();


  $post->read();
  $post->update();
  $post->delete();


  $post_arr = array(
    'secret_hash' => $post->secret_hash,
    'secret_text' => $post->secret_text,
    'view_limit' => $post->view_limit,
    'created_at' => $post->created_at,
    'expires_at' => $post->expires_at,
  );


  print_r(json_encode($post_arr));

