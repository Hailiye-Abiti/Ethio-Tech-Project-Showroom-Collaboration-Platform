// ==========================================
// Full Site Automatic Language Switcher
// ==========================================
const translations = {
    en: {
        // General / Navbar
        "መነሻ": "Home",
        "ግባ": "Login",
        "ግባ/ይመዝገቡ": "sign up/sign in",
        "ፈልግ": "Search",
        "የተመረጡ ፕሮጀክቶች": "Recent Projects",
        "መረጃውን ተመልከት": "View Details",
        "እስካሁን ምንም የተመዘገበ ፕሮጀክት የለም። የመጀመሪያውን ፕሮጀክት ለማጋራት ሎጊን ይሁኑ!": "No projects registered yet. Login to share your first project!",
        
        // Home & Hero
        "በኢትዮጵያ ውስጥ አስደናቂ የቴክኖሎጂ ፕሮጀክቶችን ያግኙ": "Discover Amazing Tech Projects in Ethiopia",
        "በሀገር ውስጥ ዴቨሎፐሮች እና ተማሪዎች የተሰሩ የሶፍትዌር ፕሮጀክቶችን ይቃኙ፣ ያጋሩ እና አብረው ይስሩ።": "Explore, share, and collaborate on software projects built by local developers and students.",
        "Search by title or tech stack (e.g., React, PHP)...": "Search by title or tech stack (e.g., React, PHP)...",
        "በርዕስ ወይም በቴክኖሎጂ ይፈልጉ (ለምሳሌ፦ React, PHP)...": "Search by title or tech stack (e.g., React, PHP)...",

        // Login / Register
        "እንኳን ደህና መጡ": "Welcome Back",
        "ወደ መለያዎ ይግቡ": "Sign in to your account",
        "ኢሜይል አድራሻ": "Email Address",
        "የይለፍ ቃል": "Password",

        // Dashboard & Add Project (የተጨመሩ አዳዲስ ቃላት)
        "የእርስዎ ዳሽቦርድ": "My Dashboard",
        "አዲስ ፕሮጀክት ጨምር": "Add New Project",
        "ዳሽቦርድ": "Dashboard",
        "ፕሮጀክቶቼ": "My Projects",
        "ፕሮጀክት ርዕስ": "Project Title",
        "ቴክኖሎጂዎች": "Tech Stack",
        "መግለጫ": "Description",
        "ፎቶ ዩአርኤል": "Image URL",
        "አስቀምጥ": "Save Project",
        "ሰርዝ": "Delete",
        "አስተካክል": "Edit"
    },
    am: {
        // General / Navbar
        "Home": "መነሻ",
        "+ Add Project":"ፕሮጀክት ጨምር",
        "Login": "ግባ",
        "sign up/sign in": "ግባ/ይመዝገቡ",
        "Search": "ፈልግ",
        "Recent Projects": "የተመረጡ ፕሮጀክቶች",
        "View Details": "መረጃውን ተመልከት",
        "No projects registered yet. Login to share your first project!": "እስካሁን ምንም የተመዘገበ ፕሮጀክት የለም። የመጀመሪያውን ፕሮጀክት ለማጋራት ሎጊን ይሁኑ!",
        
        // Home & Hero
        "Discover Amazing Tech Projects in Ethiopia": "በኢትዮጵያ ውስጥ አስደናቂ የቴክኖሎጂ ፕሮጀክቶችን ያግኙ",
        "Explore, share, and collaborate on software projects built by local developers and students.": "በሀገር ውስጥ ዴቨሎፐሮች እና ተማሪዎች የተሰሩ የሶፍትዌር ፕሮጀክቶችን ይቃኙ፣ ያጋሩ እና አብረው ይስሩ።",
        "Search by title or tech stack (e.g., React, PHP)...": "በርዕስ ወይም በቴክኖሎጂ ይፈልጉ (ለምሳሌ፦ React, PHP)...",

        // Login / Register
        "Welcome Back": "እንኳን ደህና መጡ",
        "Sign in to your account": "ወደ መለያዎ ይግቡ",
        "Email Address": "ኢሜይል አድራሻ",
        "Password": "የይለፍ ቃል",

        // Dashboard & Add Project (የተጨመሩ አዳዲስ ቃላት)
        "My Dashboard": "የእርስዎ ዳሽቦርድ",
        "Add New Project": "አዲስ ፕሮጀክት ጨምር",
        "Dashboard": "ዳሽቦርድ",
        "My Projects": "ፕሮጀክቶቼ",
        "Project Title": "ፕሮጀክት ርዕስ",
        "Tech Stack": "ቴክኖሎጂዎች",
        "Description": "መግለጫ",
        "Image URL": "ፎቶ ዩአርኤል",
        "Save Project": "አስቀምጥ",
        "Delete": "ሰርዝ",
        "Edit": "አስተካክል"
    }
};

function changeLanguage(lang) {
    localStorage.setItem('preferred_lang', lang);
    
    // የቁልፎቹን ከለር ማስተካከል
    const btnAm = document.getElementById('btnAm');
    const btnEn = document.getElementById('btnEn');
    
    if (btnAm && btnEn) {
        if (lang === 'am') {
            btnAm.style.background = '#2563eb';
            btnAm.style.color = 'white';
            btnEn.style.background = '#e5e7eb';
            btnEn.style.color = '#374151';
        } else {
            btnEn.style.background = '#2563eb';
            btnEn.style.color = 'white';
            btnAm.style.background = '#e5e7eb';
            btnAm.style.color = '#374151';
        }
    }

    // በገጹ ላይ ያሉትን ጽሁፎች በሙሉ እየቃኘ በዲክሽነሪው ውስጥ ካገኘ ይቀይራቸዋል
    document.querySelectorAll('h1, h2, h3, p, a, button, label, span, th, td').forEach(element => {
        const originalText = element.textContent.trim();
        
        if (translations[lang] && translations[lang][originalText]) {
            element.textContent = translations[lang][originalText];
        }
        
        if (element.tagName === 'INPUT' && element.placeholder) {
            const originalPlaceholder = element.placeholder.trim();
            if (translations[lang] && translations[lang][originalPlaceholder]) {
                element.placeholder = translations[lang][originalPlaceholder];
            }
        }
    });
}

window.addEventListener('DOMContentLoaded', () => {
    const savedLang = localStorage.getItem('preferred_lang') || 'en';
    changeLanguage(savedLang);

    // Dark Mode Logic
    const themeToggle = document.getElementById('themeToggle');
    const currentTheme = localStorage.getItem('theme') || 'light';

    if (currentTheme === 'dark') {
        document.body.classList.add('dark-mode');
        if (themeToggle) {
            themeToggle.innerHTML = '<i class="fa-solid fa-sun"></i>';
        }
    }

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            let theme = document.body.classList.contains('dark-mode') ? 'dark' : 'light';
            themeToggle.innerHTML = theme === 'dark' ? '<i class="fa-solid fa-sun"></i>' : '<i class="fa-solid fa-moon"></i>';
            localStorage.setItem('theme', theme);
        });
    }
});
