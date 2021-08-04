<?php

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Post.php';


  $database = new Database();
  $db = $database->connect();


  $post = new Post($db);


  $data = json_decode(file_get_contents("php://input"));
  $minute = (isset($data->time_limit) ? $data->time_limit: false);

  $post->secret_hash = uniqid();
  $post->secret_text = (isset($data->secret_text) ? $data->secret_text : false);
  $post->view_limit= (isset($data->view_limit) ? $data->view_limit : false);
  $post->created_at = $created_at = date('Y-m-d\TH:i:s.u');
  $post->expires_at = $expires_at = date('Y-m-d\TH:i:s.u',strtotime('+' . $minute . 'minutes',strtotime($created_at)));

  if($post->view_limit=0){
    echo json_encode(
      array('message' => 'Invalid input')
    );
  }
    if($post->create()) {
    echo json_encode(
      array('message' => 'Successful operation')
    );

  } else {
    echo json_encode(
      array('message' => 'Post Not Created, Invalid input')
    );
  }

