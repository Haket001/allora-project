document.addEventListener('DOMContentLoaded', function() {
    let openBtn = document.querySelector('.open-filter-modal');
    let modal = document.getElementById('filter-modal');
    let closeBtn = modal.querySelector('.close-modal');
    
    if (openBtn) {
        openBtn.addEventListener('click', function(e) {
            e.preventDefault();
            modal.style.display = 'block';
        });
    }
    
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }
    
    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});