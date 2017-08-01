//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@@@@@@    ADMIN    @@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//

var domReady = function (callback) {
    document.readyState === "interactive" || document.readyState === "complete" ? callback() : document.addEventListener("DOMContentLoaded", callback);
};

domReady(function () {

    function adminFormUpload() {

        var form = document.querySelector('.container_admin form');

        if (form) {

            var maxSize = form.querySelector('[name="MAX_FILE_SIZE"]').value;
            var result = form.querySelector('.container_upload_result');

            form.onsubmit = function(e) {

                var file = form.querySelector('[type="file"]').files[0];

                if (file) {

                    var fileSize = file.size;

                    if (fileSize > maxSize) {
                        e.preventDefault();
                        result.textContent = 'The image weighs more than 2MB.';
                    } 

                }

            };

        }

    }

    function initAdmin() {
        adminFormUpload();
    }

    initAdmin();

});