<?php 

  include('config/db_connection.php'); 

  // SAVING NOTES TO THE DB:
  
  // where form errors are stored
  $errors = array('note_title' =>'', 'user_note' => '');

  // Validate notes form

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
      $title = mysqli_real_escape_string($db_connection, $_POST['note_title']);
      $user_note = mysqli_real_escape_string($db_connection, $_POST['user_note']);

      // create sql
      $sql = "INSERT INTO notes(title,user_note) VALUES('$title', '$user_note');";
      $sql .= "SELECT user_name FROM notes";

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

  // getting data from db: get the user name and user note

  // construct query
  $sql = 'SELECT title, user_note, user_name FROM notes';

  // make query and get results
  $result = mysqli_query($db_connection, $sql);

  // fetch the resulting rows as an array
  $user_info = mysqli_fetch_all($result, MYSQLI_ASSOC);

  // free memory [result]
  mysqli_free_result($result);

  // close db connection
  // mysqli_close($db_connection);

  // print_r($user_info)

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/notepad.css">
  <script type="module" defer src="./js/index.js"></script>
  <title>Note Pad</title>
</head>
<body>
  <nav class="nav-container">
    <a href="./index.php"><h1 class="logo">NotePad</h1></a>
    <span class="username">
      <?php  foreach($user_info as $info){ echo htmlspecialchars($info['user_name']); }?>
    </span>
    <button class="add-note-btn">Add Note</button>
  </nav>
  <!-- modal -->
  <div class="modal-overlay">
    <form action='notes.php' method='POST' class="modal-container">
      <h4 class="modal-title">Write Your Note...</h4>
      <input type="text" name="note_title" id="note-title" placeholder="Note Title"/>
      <textarea name="user_note" id="modal-textarea" placeholder="Note"></textarea>
      <input type="submit" value="save" name='submit' class="modal-btn">
    <form>
  </div>
  <div class="user-notnote</div>
</body>
</html>


<!-- option: separate page - notes page [form], entry name [start page] and output page [rendered data] -->
<!-- from the start page, redirect to notes page [form] then from there go to rendered data page -->