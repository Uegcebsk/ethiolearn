function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'en',
        includedLanguages: 'en,am',
        layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL
    }, 'google_translate_element');
}
