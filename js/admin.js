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
            var result = document.querySelector('.container_upload_result');

            form.onsubmit = function(e) {
                e.preventDefault();

                var nameInput = form.querySelector('[type="text"]').value;
                var urlInput = form.querySelector('[type="url"]').value;
                var file = form.querySelector('[type="file"]').files[0];

                if (file && nameInput.length !== 0 && urlInput.length !== 0) {
                    
                    var fileSize = file.size;
                    var fileName = file.name;
                    var fileType = wordInString(fileName, '.jpg') || wordInString(fileName, 'jpeg') || wordInString(fileName, '.png');

                    if (fileSize < maxSize && fileType) {
                        fetch('./upload', {
                            method: "POST",
                            body: new FormData(form),
                            credentials: "same-origin"
                        }).then(function(response) {
                            if (response.ok) {
                                result.innerHTML = 'Successo, tutti i campi inviati';
                                form.reset();
                            } else {
                                var error = new Error(response.statusText);
                                error.response = response;
                                throw error;
                                result.innerHTML = 'Errore: ' + error;
                            }
                        });
                    } else {
                        result.innerHTML = 'Il file pesa piu di 2mb o non è del formato corretto';
                        form.querySelector('[type="file"]').value = '';
                        form.querySelector('[type="file"]').type = '';
                        form.querySelector('[type="file"]').type = 'file';
                    }

                } else {
                    result.innerHTML = 'controlla tutti i campi';
                }

            };

        }

    }

    function initAdmin() {
        adminFormUpload();
    }

    initAdmin();

});