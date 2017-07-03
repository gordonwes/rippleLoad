/////// Cookie //////////////////

function setCookie() {
    var infCookie = document.getElementById("informativa_cookie");
    var buttCookie = document.getElementById("ok_cookie");

    if (!Cookies.get(nameCookie)) {
        infCookie.style.display = "block";
        buttCookie.addEventListener('click', function(e) {
            e.preventDefault();
            Cookies.set(nameCookie, '1', {expires: 9999});
            var slideOutCookie = anime({
                targets: infCookie,
                translateY: '100%',
                duration: 600,
                easing: 'easeInOutQuad',
                complete: function() {
                    infCookie.style.display = "none";
                }
            });
        });
    }

}