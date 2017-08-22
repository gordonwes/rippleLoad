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

            var inputImage = document.querySelector('.container_image_upload input[type="file"]');

            inputImage.addEventListener('change', function() {
                var nameFile = this.value.replace(/.*[\/\\]/, '');
                if (nameFile !== '') {
                    inputImage.parentElement.querySelector('span').textContent = nameFile;
                } else {
                    inputImage.parentElement.querySelector('span').textContent = 'Upload image';
                }
            });

        }

    }

    function initAdmin() {
        adminFormUpload();
    }

    initAdmin();

});