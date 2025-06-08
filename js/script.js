const toggleBtn = document.getElementById('menu-toggle');
const sidebar = document.getElementById('sidebar');
const body = document.body;

toggleBtn.addEventListener('click', () => {
  toggleBtn.classList.toggle('active');
  sidebar.classList.toggle('open');
  body.classList.toggle('sidebar-open');
});

// Soporte de teclado (Enter or Space)
toggleBtn.addEventListener('keydown', (e) => {
  if (e.key === 'Enter' || e.key === ' ') {
    e.preventDefault();
    toggleBtn.click();
  }
});

