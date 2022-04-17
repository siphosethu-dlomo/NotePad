export default function popUpModal() {
  const addNoteBtn = document.querySelector('.add-note-btn');
  const modalOverlay = document.querySelector('.modal-overlay');
  const modalBtn = document.querySelector('.modal-btn');
  const noteTitle = document.getElementById('note-title');
  const textArea = document.getElementById('modal-textarea');
  const userNotes = document.querySelector('.user-notes');
 
  
  addNoteBtn.addEventListener('click', () => {
    modalOverlay.classList.add('open-modal');
  });

  modalBtn.addEventListener('click', ()=> {
    modalOverlay.classList.remove('open-modal');
    const bodyContent = `
    <?php  foreach($user_info as $info){ ?>
      <div>
        <h1><?php htmlspecialchars($info['title']); ?></h1>
        <p><?php htmlspecialchars($info['user_note']); ?></p>
      </div>
    <?php } ?>
    `;
    
    userNotes.innerHTML = bodyContent;

  });
};