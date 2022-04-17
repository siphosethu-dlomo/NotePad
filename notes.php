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
    <span class="username">Sipho</span>
    <button class="add-note-btn">Add Note</button>
  </nav>
  <div class="modal-overlay">
    <form class="modal-container">
      <h4 class="modal-title">Write Your Note...</h4>
      <input type="text" name="note-title" id="note-title" placeholder="Note Title"/>
      <textarea name="notes" id="modal-textarea" placeholder="Note"></textarea>
      <input type="button" value="save" class="modal-btn">
    <form>
  </div>
  <div class="user-notes"></div>
</body>
</html>