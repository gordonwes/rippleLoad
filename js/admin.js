//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@@@@@@    ADMIN    @@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//

var domReady = function (callback) {
    document.readyState === "interactive" || document.readyState === "complete" ? callback() : document.addEventListener("DOMContentLoaded", callback);
};

domReady(function () {

    function adminImageUpload() {

        var form = document.querySelector('.container_admin form');

        form.onsubmit = function(e) {
            e.preventDefault();

            fetch('./upload', {
                method: "POST",
                body: new FormData(form),
                credentials: "same-origin"
            }).then(function(response) {
                if (response.ok) {
                    console.log('perfetto');
                } else {
                    var error = new Error(response.statusText);
                    error.response = response;
                    throw error;
                }
            });

        };

    }

    function initAdmin() {
        adminImageUpload();
    }

   // initAdmin();

});