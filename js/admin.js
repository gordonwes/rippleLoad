//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@@@@@    ADMIN    @@@@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//

var domReady = function (callback) {
    document.readyState === "interactive" || document.readyState === "complete" ? callback() : document.addEventListener("DOMContentLoaded", callback);
};

domReady(function () {

    function showImageInput(elem, img) {
        var placeholderImg = document.querySelector('.placeholder_image');
        if (elem.files && elem.files[0]) {
            var typeFile = elem.files[0].type;
            if (typeFile.indexOf('image') > -1) {
                placeholderImg.src = URL.createObjectURL(elem.files[0]);
                placeholderImg.style.display = 'block';
            }
        } else {
            placeholderImg.src = baseUrl + '/' + img;
            placeholderImg.style.display = 'block';
        }
    }

    function fileUpload() {

        var inputFile = document.querySelector('input[type="file"]');
        var oldValue = inputFile.value;

        if (inputFile) {

            inputFile.addEventListener('change', function() {
                var nameFile = this.value.replace(/.*[\/\\]/, '');
                if (nameFile !== '') {
                    this.parentElement.querySelector('span').textContent = nameFile;
                } else {
                    this.parentElement.querySelector('span').textContent = oldValue;
                }
                showImageInput(this);
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
                triggerEditProject = parentListedProject.querySelectorAll('.edit_project'),
                mainForm = document.querySelector('form.main_form'),
                updateTrigger = mainForm.querySelector('[name="submit"]'),
                inputName = mainForm.querySelector('[name="projectname"]'),
                textareaDesc = mainForm.querySelector('[name="projectdesc"]'),
                inputUrl = mainForm.querySelector('[name="projecturl"]'),
                selectSize = mainForm.querySelector('[name="projectsize"]'),
                inputFile = mainForm.querySelector('[name="newfile"]'),
                checkTags = mainForm.querySelectorAll('[name="projecttags[]"]'),
                inputOrder = mainForm.querySelector('[name="projectorder"]'),
                triggerChangeOrder = document.querySelector('.trigger_change_order'),
                newProject = true;

            function editProject(e, elem) {
                e.preventDefault();
                var parent = elem.parentElement,
                    timestampProject = encodeURI(parent.querySelector('[name="timestamp_project"]').value),
                    activeEditProject = parent.parentElement.querySelector('.active_project');

                if (!parent.classList.contains('active_project') && activeEditProject) {
                    activeEditProject.classList.remove('active_project');
                }

                if (newProject) {
                    parent.classList.add('active_project');
                    parentListedProject.classList.add('active_list');
                    newProject = false;

                    var request = new XMLHttpRequest();

                    request.addEventListener("error", function() {
                        console.log('error edit project');
                    }, false);

                    request.addEventListener("abort", function() {
                        console.log('abort edit project');
                    }, false);

                    request.onreadystatechange = function() {
                        if (request.readyState === 4) {
                            var dataProject = request.response;
                            var titleUpdateProject = dataProject.title,
                                descUpdateProject = dataProject.description,
                                urlUpdateProject = dataProject.url,
                                tagsUpdateProject = dataProject.tags,
                                sizeUpdateProject = dataProject.size,
                                coverUpdateProject = dataProject.cover,
                                orderProject = dataProject.orderid;

                            updateFormProject(orderProject, titleUpdateProject, descUpdateProject, urlUpdateProject, tagsUpdateProject, sizeUpdateProject, coverUpdateProject, timestampProject);
                        }
                    }

                    request.open('GET', baseUrl + '/get/project/' + timestampProject, true);
                    request.responseType = 'json';
                    request.send();

                } else {
                    parent.classList.remove('active_project');
                    parentListedProject.classList.remove('active_list');
                    resetFormProject();
                    newProject = true;
                }

            }

            function updateFormProject(orderid, title, desc, url, tags, size, cover, timestampProject) {

                inputName.value = title;
                textareaDesc.value = desc;
                inputUrl.value = url;
                inputOrder.value = orderid;

                if (size) {
                    if (size.trim() !== '') {
                        selectSize.value = size;
                    } else {
                        selectSize.value = 'normal';
                    }
                }

                mainForm.setAttribute('action', baseUrl + '/edit/project/' + timestampProject);

                forEach(checkTags, function (index, elem) {
                    if (tags.indexOf(elem.value) > -1) {
                        elem.checked = true;
                    }
                });

                inputFile.removeAttribute('required');
                showImageInput(inputFile, cover);

                updateTrigger.value = 'UPDATE PROJECT';

            }

            function resetFormProject() {
                mainForm.setAttribute('action', baseUrl + '/upload/project');
                updateTrigger.value = 'UPLOAD PROJECT';
                inputFile.setAttribute('required', 'true');
                document.querySelector('.placeholder_image').style.display = 'none';
                mainForm.reset();
            }

            forEach(triggerEditProject, function (index, elem) {
                elem.addEventListener('click', function(e) {
                    editProject(e, this);
                });
            });

            var listProjects = new Packery(parentListedProject, {
                itemSelector: '.single_prj',
                percentPosition: true
            });

            listProjects.getItemElements().forEach(function(itemElem) {

                var draggie = new Draggabilly(itemElem, {
                    axis: 'y',
                    containment: '.container_drag'
                });

                listProjects.bindDraggabillyEvents(draggie);

                draggie.on('pointerDown', function(event, pointer) {
                    parentListedProject.classList.add('drag_active');
                });

                draggie.on('pointerUp', function(event, pointer) {
                    parentListedProject.classList.remove('drag_active');
                });

            });

            function orderProjects() {
                listProjects.getItemElements().forEach(function(itemElem, i) {
                    itemElem.setAttribute('data-id', i);
                });
                triggerChangeOrder.style.display = 'inline-block';
            }

            listProjects.on('layoutComplete', orderProjects);
            listProjects.on('dragItemPositioned', orderProjects);

            function sendNewOrderProjects(e) {
                e.preventDefault();
                triggerChangeOrder.style.display = 'none';
                forEach(parentListedProject.children, function (index, elem) {
                    var timestampProject = elem.querySelector('[name="timestamp_project"]').value;

                    var requestOrder = new XMLHttpRequest();

                    requestOrder.addEventListener("error", function() {
                        console.log('error edit idorder');
                    }, false);

                    requestOrder.addEventListener("abort", function() {
                        console.log('abort edit idorder');
                    }, false);

                    var newOrderId = elem.getAttribute('data-id');

                    var updatedValueProject = {
                        'timestamp': timestampProject,
                        'orderid': newOrderId
                    }

                    requestOrder.open('POST', baseUrl + '/update/project', true);
                    requestOrder.setRequestHeader("Content-type", 'application/json');
                    requestOrder.send(JSON.stringify(updatedValueProject));
                });
                location.reload();
            }

            triggerChangeOrder.addEventListener('click', function(e) {
                sendNewOrderProjects(e);
            });


        }

    }

    fileUpload();

});