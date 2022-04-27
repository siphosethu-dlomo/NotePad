<?php 

  include('config/db_connection.php'); 

  // SAVING NOTES TO THE DB:
  
  // for persisting form data
  $user_name = '';
  $note_title = '';
  $user_note = '';

  // where form errors are stored
  $errors = array('note_title' =>'', 'user_note' => '', 'user_name' =>'');

  // Validate notes form 
  // when the saved button is pressed, user's note is sent to the db 
  if(isset($_POST['submit'])) {
    // check if there is a username
    if(empty($_POST['user_name'])) {
      $errors['user_name'] = 'username required';
    } else {
      $user_name = htmlspecialchars($_POST['user_name']);
    }

     // checking if there is a note title
    if(empty($_POST['note_title'])) {
      $errors['note_title'] = 'note title required';
    } else {
      $note_title = htmlspecialchars($_POST['note_title']);
    }

    // check if there is a note
    if(empty($_POST['user_note'])) {
      $errors['user_note'] = 'you forget to write your note';
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

  // GETTING USER DATA FROM DB: GET THE USER THE USER'S NAME AND USER'S NOTE 

  // construct query
  $sql = 'SELECT title, user_note, user_name, id FROM notes';

  // make query and get results
  $result = mysqli_query($db_connection, $sql);

  // fetch the resulting rows as an array
  $user_info = mysqli_fetch_all($result, MYSQLI_ASSOC);


  // DELETE NOTE
  if(isset($_POST['delete'])) {
    $id_to_delete = mysqli_real_escape_string($db_connection, $_POST['id_to_delete']);

    $sql = "DELETE FROM notes WHERE id = $id_to_delete";

    if(mysqli_query($db_connection, $sql)) {
      // success
      header('Location: notes.php');
    } else {
      // failure
      echo 'quary error: ' . mysqli_error($db_connection);
    }

    // free memory [result]
    mysqli_free_result($result);

    // close db connection
    mysqli_close($db_connection);
  }

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

      <p class="error"><?php echo htmlspecialchars($errors['user_name']); ?></p>
      <input type="text" name="user_name" id="username" placeholder="username" value="<?php echo $user_name ?>"/>

      <p class="error"><?php echo htmlspecialchars($errors['note_title']); ?></p>
      <input type="text" name="note_title" id="note-title" placeholder="note title" value="<?php echo $note_title ?>"/>

      <p class="error"><?php echo htmlspecialchars($errors['user_note']); ?></p>
      <textarea name="user_note" id="modal-textarea" placeholder="note" value="<?php echo $user_note ?>"></textarea>

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
        <form action="notes.php" method="POST">
          <input type="hidden" name="id_to_delete" value="<?php echo htmlspecialchars($info['id']); ?>" />
          <input type="submit" name="delete" value="Delete" class="delete-btn" />
        </form>
      </div>


    <?php } ?>
  </div>

</body>
</html>