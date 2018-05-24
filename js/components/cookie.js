/////// Cookie //////////////////

function setCookie() {
    var infCookie = document.getElementById("informativa_cookie");
    var buttCookie = document.getElementById("contenitore_bottone_cookie");

    var removeCookieBanner = function(e) {
        if (e.target.nodeName == 'A') {
            e.preventDefault();
            var isOk = e.target.getAttribute('id') == 'ok_cookie';
            if (isOk) {
                Cookies.set(nameCookie, '1', {expires: 9999});
            }
            var slideOutCookie = anime({
                targets: infCookie,
                translateY: '100%',
                duration: 600,
                easing: 'easeInOutQuad',
                complete: function() {
                    infCookie.style.display = "none";
                    if (isOk) {
                        buttCookie.removeEventListener('click', removeCookieBanner, false);
                    }
                }
            });
        }
    }

    if (!Cookies.get(nameCookie)) {
        infCookie.style.display = "block";
        var slideInCookie = anime({
            targets: infCookie,
            translateY: ['100%', '0%'],
            duration: 600,
            delay: 1200,
            easing: 'easeInOutQuad',
            begin: function() {
                buttCookie.addEventListener('click', removeCookieBanner, false);
            }
        });
    }

}