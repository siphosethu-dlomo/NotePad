const addNoteBtn = document.querySelector('.add-note-btn');
const modalOverlay = document.querySelector('.modal-overlay');

// pop-up form 
addNoteBtn.addEventListener('click', () => {
  modalOverlay.classList.add('open-modal');
});