<?php 

  include('config/db_connection.php'); 

  // SAVING NOTES TO THE DB:
  
  // where form errors are stored
  $errors = array('note_title' =>'', 'user_note' => '');

  // Validate notes form 
  // when the saved button is pressed, user's note is sent to the db 
  if(isset($_POST['submit'])) {
     // checking if there is a note title
    if(empty($_POST['note_title'])) {
      $errors['note_title'] = 'note title required <br />';
    } else {
      $note_title = htmlspecialchars($_POST['note_title']);
    }

    // check if there is a note
    if(empty($_POST['user_note'])) {
      $errors['user_note'] = 'You forget to write your note <br />';
    } else {
      $user_note = htmlspecialchars($_POST['user_note']);
    }

    // CHECKING FOR FORM ERRORS AND SAVING DATA TO DB 
    if(array_filter($errors)) {
      // echo form error(s)
    } else {
      // saving user's data to the datbase

      // taking the user's inputs to be sent to the db
      $title = mysqli_real_escape_string($db_connection, $_POST['note_title']);
      $user_note = mysqli_real_escape_string($db_connection, $_POST['user_note']);
      $username = mysqli_real_escape_string($db_connection, $_POST['user_name']);

      // create sql
      $sql = "INSERT INTO notes(title,user_note, user_name) VALUES('$title', '$user_note', '$username');";

      // save to db 
      if(mysqli_multi_query($db_connection, $sql)) {
        // success, redirect to page
        header('Location: notes.php');
      } else {
        // error
        echo 'query error: ' . mysqli_error($db_connection);
      }
    }
  }

  // getting user data from db: get the user name and user note

  // construct query
  $sql = 'SELECT title, user_note, user_name FROM notes';

  // make query and get results
  $result = mysqli_query($db_connection, $sql);

  // fetch the resulting rows as an array
  $user_info = mysqli_fetch_all($result, MYSQLI_ASSOC);

  // free memory [result]
  mysqli_free_result($result);

  // close db connection
  mysqli_close($db_connection);

  // print_r($user_info)

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/notepad.css">
  <script defer src="./js/popUpModal.js"></script>
  <title>Note Pad</title>
</head>
<body>
  <nav class="nav-container">
    <h1 class="logo">NotePad</h1>
    <button class="add-note-btn">Add Note</button>
  </nav>
  <!-- modal -->
  <div class="modal-overlay">
    <form action='notes.php' method='POST' class="modal-container">
      <h4 class="modal-title">Write Your Note...</h4>
      <input type="text" name="user_name" id="username" placeholder="username"/>
      <input type="text" name="note_title" id="note-title" placeholder="note title"/>
      <textarea name="user_note" id="modal-textarea" placeholder="note"></textarea>
      <input type="submit" value="save" name='submit' class="modal-btn">
    <form>
  </div>

  <!-- notes output -->
  <div class="users-notes-container">
    <?php  foreach($user_info as $info){ ?>
      <div class="note-card">
        <h1 class="note-title" ><?php echo htmlspecialchars($info['title']); ?></h1>
        <p class="note"><?php echo htmlspecialchars($info['user_note']); ?></p>
        <small class="author" ><?php echo htmlspecialchars($info['user_name']); ?></small>
      </div>
    <?php } ?>
  </div>

</body>
</html>