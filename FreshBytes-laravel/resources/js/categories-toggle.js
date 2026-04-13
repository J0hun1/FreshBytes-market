document.addEventListener('DOMContentLoaded', function() {
  const toggleBtn = document.getElementById('categories-toggle-btn');
  if (!toggleBtn) return;

  toggleBtn.addEventListener('click', function(e) {
    e.preventDefault();

    const allGrid = document.getElementById('all-categories-grid');
    if (!allGrid) return;

    if (allGrid.classList.contains('hidden')) {
      // Show dropdown
      allGrid.classList.remove('hidden');
      this.textContent = 'Hide all';
    } else {
      // Hide dropdown
      allGrid.classList.add('hidden');
      this.textContent = 'View all';
    }
  });
});
