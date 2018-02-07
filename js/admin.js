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

            var parentListedProject = document.querySelector('.container_drag'),
                triggerEditProject = parentListedProject.querySelectorAll('.edit_project');

            function editProject(e, elem) {
                e.preventDefault();
                var parent = elem.parentElement,
                    timestampProject = encodeURI(parent.querySelector('[name="timestamp_project"]').value),
                    activeEditProject = parent.parentElement.querySelector('.active_project');

                if (activeEditProject) {
                    activeEditProject.classList.remove('active_project');
                }

                parent.classList.add('active_project');
                parentListedProject.classList.add('active_list');

                /*                var request = new XMLHttpRequest();

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

                request.send();*/

            }

            forEach(triggerEditProject, function (index, elem) {
                elem.addEventListener('click', function(e) {
                    editProject(e, this);
                });
            });

            var draggableProjects = document.querySelectorAll('.list_projects .single_prj'),
                draggableProjectsLenght = draggableProjects.length,
                heightContainerBlockDrag = document.querySelector('.list_projects .container_drag').offsetHeight,
                heightBlockDrag = draggableProjects[0].offsetHeight + 5,
                draggies = [];

            for ( var i=0, len = draggableProjects.length; i < len; i++ ) {
                var draggableProject = draggableProjects[i];
                var draggie = new Draggabilly(draggableProject, {
                    axis: 'y',
                    containment: '.container_drag'
                });
                draggie.on('pointerDown', function(event, pointer) {
                    parentListedProject.classList.add('drag_active');
                });
                draggie.on('pointerUp', function(event, pointer) {
                    parentListedProject.classList.remove('drag_active');
                });
                draggie.on('dragMove', function(event, pointer, moveVector) {

                    var movDiff = moveVector.y,
                        blockPassed = ~~(movDiff / heightBlockDrag),
                        preElem = draggableProjects[draggableProjectsLenght - i + blockPassed];

                    if (movDiff > 0 && blockPassed >= 1) {
                        console.log('va sotto di ' + blockPassed);
                        preElem.appendChild(draggableProject);
                        draggableProject.parentNode.removeChild(draggableProject);
                    } else if(movDiff < 0 && blockPassed <= -1) {
                        console.log('va sopra di ' + blockPassed);
                        preElem.appendChild(draggableProject);
                        draggableProject.parentNode.removeChild(draggableProject);
                    }

                });
                draggies.push(draggie);
            }

        }

    }

    fileUpload();

});