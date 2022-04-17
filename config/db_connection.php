<!-- database connection -->
<?php

// connect to database
$db_connection = mysqli_connect('localhost', 'sipho', 'note', 'note_pad');

// check connection
if(!$db_connection) {
  echo 'Connection error: ' . mysqli_connect_error();
};
