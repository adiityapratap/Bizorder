$(document).ready(function() {
    // Default language
    let currentLang = 'en'; // Default to English
    
    // Load language on page load
    loadLanguage(currentLang);
    
    // Handle language switch
    $('.dropdown-menu .dropdown-item').on('click', function(e) {
        e.preventDefault();
        let newLang = $(this).data('lang');
        loadLanguage(newLang);
    });
    
    // Function to load language
    function loadLanguage(lang) {
        $.getJSON('assets/lang/' + lang + '.json', function(data) {
            $('[data-lang]').each(function() {
                let key = $(this).data('lang');
                console.log("data",data[key])
                $(this).text(data[key]);
            });
            currentLang = lang;
        });
    }
});
