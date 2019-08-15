<?php
  require_once 'classes/ErrorHandler.php';
  require_once 'classes/Validator.php';

  $errorHandler = new ErrorHandler;


  if(!empty($_POST)){
    $validator = new Validator($errorHandler);

    $validation = $validator->check($_POST, [
      'username' => [
        'required' => true,
        'maxlength' => 20,
        'minlength' => 3      
      ],
      'email' => [
        'required' => true,
        'maxlength' => 255,
        'email' => true      
      ],
      'password' => [
        'required' => true,
        'minlength' => 6   
      ]
    ]);

    //calling all on errors, referring to errors method in ErrorHandler
    if($validation->fails()){
      print_r($validation->errors()->all());
    }
  }

  
  
  // if($errorHandler->hasErrors()){
  //   echo '<pre>' . print_r($errorHandler->all()) . '</pre>';
  //   echo '<pre>' . print_r($errorHandler->all('username')) . '</pre>';
  //   echo $errorHandler->first('username');
  // }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <form action="index.php" method="post">
    <div>
      Username: <input type="text" name="username">
    </div>
    <div>
      Email: <input type="text" name="email">
    </div>
    <div>
      Password: <input type="password" name="password">
    </div>
    <div>
       <input type="submit" >
    </div>
  </form>
</body>
</html>