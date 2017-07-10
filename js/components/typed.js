function initType(page) {
    
    if (typeof typeText != 'undefined') {
        typeText.destroy();
        console.log(distrutto);
    }

    var textType = page.querySelector('.text_typed');

    var options = {
        stringsElement: '#container_text_typed',
        startDelay: 100,
        typeSpeed: 40,
        onComplete: function() {

        }
    }

    var typeText = new Typed(textType, options);

}