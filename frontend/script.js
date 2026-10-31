// Dark Mode Toggle Logic
const themeToggleBtn = document.getElementById('themeToggle');
const bodyElement = document.body;
const themeIcon = themeToggleBtn ? themeToggleBtn.querySelector('i') : null;

// Check saved user preference on load
const currentTheme = localStorage.getItem('theme');
if (currentTheme === 'dark') {
    bodyElement.classList.add('dark-mode');
    if (themeIcon) {
        themeIcon.classList.replace('fa-moon', 'fa-sun');
    }
}

if (themeToggleBtn) {
    themeToggleBtn.addEventListener('click', () => {
        bodyElement.classList.toggle('dark-mode');
        
        let theme = 'light';
        if (bodyElement.classList.contains('dark-mode')) {
            theme = 'dark';
            if (themeIcon) {
                themeIcon.classList.replace('fa-moon', 'fa-sun');
            }
        } else {
            if (themeIcon) {
                themeIcon.classList.replace('fa-sun', 'fa-moon');
            }
        }
        
        // Save preference to localStorage
        localStorage.setItem('theme', theme);
    });
}
