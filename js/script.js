// --- Sidebar toggle logic ---
const toggleBtn = document.getElementById('menu-toggle');
const sidebar = document.getElementById('sidebar');
const body = document.body;

if (toggleBtn && sidebar) {
  toggleBtn.addEventListener('click', () => {
    toggleBtn.classList.toggle('active');
    sidebar.classList.toggle('open');
    body.classList.toggle('sidebar-open');
  });

  // Close sidebar on Escape
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && sidebar.classList.contains('open')) {
      sidebar.classList.remove('open');
      toggleBtn.classList.remove('active');
      body.classList.remove('sidebar-open');
    }
  });

  // Close sidebar on outside click
  document.addEventListener('click', (event) => {
    const isClickInsideSidebar = sidebar.contains(event.target);
    const isClickOnToggle = toggleBtn.contains(event.target);
    if (!isClickInsideSidebar && !isClickOnToggle && sidebar.classList.contains('open')) {
      sidebar.classList.remove('open');
      toggleBtn.classList.remove('active');
      body.classList.remove('sidebar-open');
    }
  });
}

const profileIcon = document.getElementById('profile-icon');
const profileDropdown = document.getElementById('profile-dropdown');

if (profileIcon && profileDropdown) {
  profileIcon.addEventListener('click', (e) => {
    e.stopPropagation();
    profileDropdown.classList.toggle('open');
  });

  document.addEventListener('click', (e) => {
    if (!profileDropdown.contains(e.target) && !profileIcon.contains(e.target)) {
      profileDropdown.classList.remove('open');
    }
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      profileDropdown.classList.remove('open');
    }
  });
}


