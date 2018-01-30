/////////  START JS ///////////

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@    EVERYTHING READY    @@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//

domReady(function () {

    var mainContainer = document.querySelector('.barba-container');

    setCookie();

    initBarba();

    initPages(mainContainer);
        
});