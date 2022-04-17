<?php 

include('config/db_connection.php'); 

$error = array('user_name' =>'');

if(isset($_POST['submit'])) {
  // check if user name input is empty
  if(empty($_POST['user_name'])) {
    $error['user_name'] = 'user name required <br />';
  } else {
    $user_name = htmlspecialchars($_POST['user_name']);
  }

  // check for form errors and redirect to next page
  if(array_filter($error)) {
  // echo errors
  } else {
    // saving user's data to the datbase
    $user_name = mysqli_real_escape_string($db_connection, $_POST['user_name']);

    // create sql
    $sql = "INSERT INTO notes(user_name) VALUES('$user_name')";

    // save to db
    if(mysqli_query($db_connection, $sql)) {
      // success, redirect to page
      header('Location: notes.php');
    } else {
      echo 'query error: ' . mysqli_error($db_connection);
    }
    
  }

}
 

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/styles.css">
  <title>Note Pad</title>
</head>

<body>
  <main>
    <div class="heading-container">
      <h3>Note Pad</h3>
      <p>Write all you want</p>
    </div>
    <form action="index.php" method="POST" class="form-home">
      <input 
        type="text" 
        name="user_name" id="user-name" 
        placeholder="My Name" 
        class="form-home-input"
      /><br />
      <div class="form-error-username"><?php echo $error['user_name']; ?></div>
      <a href="#"><input type="submit" name='submit' value="Proceed" class="form-home-btn" /></a>
    </form>
  </main>
</body>

</html>

<!-- create header template -->
<!-- net ninja for template -->