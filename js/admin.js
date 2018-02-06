//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@@@@@    ADMIN    @@@@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//

var domReady = function (callback) {
    document.readyState === "interactive" || document.readyState === "complete" ? callback() : document.addEventListener("DOMContentLoaded", callback);
};

domReady(function () {

    function fileUpload() {

        var inputFile = document.querySelector('input[type="file"]');
        var oldValue = inputFile.value;

        if (inputFile) {

            inputFile.addEventListener('change', function() {
                var nameFile = this.value.replace(/.*[\/\\]/, '');
                if (nameFile !== '') {
                    inputFile.parentElement.querySelector('span').textContent = nameFile;
                } else {
                    inputFile.parentElement.querySelector('span').textContent = oldValue;
                }
            });

        }

        var uploadAll = document.querySelector('.container_file_upload');

        if (uploadAll) {

            var formAll = uploadAll.parentElement,
                url = formAll.getAttribute('action'),
                progressBar = document.getElementById('progressBar'),
                progressCount = document.getElementById('progressCount');

            function sendFile(file) {

                if (file.size < 100000000) { // 100MB

                    var request = new XMLHttpRequest();

                    request.upload.addEventListener("progress", function(evt) {

                        if (evt.lengthComputable) {
                            var percentComplete = Math.round(evt.loaded / evt.total * 100) + '%'; 
                            progressBar.max = evt.total;
                            progressBar.value = evt.loaded;
                            progressCount.textContent = percentComplete;
                        }

                    }, false);

                    request.addEventListener("load", function() {
                        setTimeout(function() {
                            formAll.submit();
                        }, 200);
                    }, false);

                    request.addEventListener("error", function() {
                        console.log('error');
                    }, false);

                    request.addEventListener("abort", function() {
                        console.log('abort');
                    }, false);

                    request.open('POST', url, true);

                    request.setRequestHeader("Content-type", file.type);
                    request.setRequestHeader("X_FILE_NAME", file.name);

                    request.send(file);

                } else {
                    document.querySelector('.file_big').style.display = 'block';
                    if (formAll.classList.contains('on_load')) {
                        formAll.classList.remove('on_load');
                    }
                }

            }

            formAll.addEventListener('submit', function(e) {
                e.preventDefault();
                formAll.classList.add('on_load');
                var file = inputFile.files[0];
                sendFile(file);
            });

            inputFile.addEventListener('change', function() {
                document.querySelector('.file_big').style.display = 'none';
                if (formAll.classList.contains('on_load')) {
                    formAll.classList.remove('on_load');
                }
            });

        }

        var listedProject = document.querySelector('.list_projects .single_prj');

        if (listedProject) {

            var triggerEditProject = listedProject.querySelector('.edit_project');

            function editProject(e) {
                e.preventDefault();
                var timestampProject = encodeURI(triggerEditProject.parentElement.querySelector('[name="timestamp_project"]').value);

                console.log(timestampProject);

                var request = new XMLHttpRequest();

                request.addEventListener("error", function() {
                    console.log('error edit project');
                }, false);

                request.addEventListener("abort", function() {
                    console.log('abort edit project');
                }, false);

                request.onreadystatechange = function() {
                    if (request.readyState === 4) {
                        console.log(request.response);
                    }
                }

                request.open('GET', baseUrl + '/edit/project/' + timestampProject, true);

                request.send();

            }

            triggerEditProject.addEventListener('click', function(e) {
                editProject(e);
            });

        }

    }

    fileUpload();

});