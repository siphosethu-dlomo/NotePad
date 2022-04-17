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
    <div>
      <h1>${noteTitle.value}</h1>
      <p>${textArea.value}</p>
    </div>
    `;
    
    userNotes.innerHTML = bodyContent;

  });
};