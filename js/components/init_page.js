function initPages(page) {

    var actualPage = page.getAttribute('data-namespace');

    if (actualPage === 'projects') {

        var projectsContainer = page.querySelector('.container_projects');
        var scrollArea = page.querySelector('.vertical_align');
        var projects = page.querySelectorAll('.project');
        var filterCount = page.querySelector('.count');

        function initProjects() {

            showProjectOnScroll(projects);

        }

        function showProjectOnScroll(projectArray) {

            forEach(projectArray, function (index, elem) {

                var hiddenProject = true;

                function setAnimationElem() {

                    var projectTop = elem.getBoundingClientRect().top;
                    var heightProject = elem.offsetHeight;

                    if (projectTop - docHeight < -(heightProject / 2) && hiddenProject) {
                        var animProject = anime({
                            targets: elem,
                            opacity: ['0', '1'],
                            translateY: ['1.5rem', '0'],
                            duration: 500,
                            easing: 'easeInOutQuad',
                            begin: function(anim) {
                                hiddenProject = false;
                            }
                        });

                    }

                }

                function requestTick() {
                    requestAnimationFrame(setAnimationElem);
                }

                setAnimationElem();
                scrollArea.addEventListener('scroll', requestTick);

            });

        }

        function loadNewProject() {

            fetch('./get', {  // ?result=10
                method: "POST",
                headers: {
                    'Accept': 'application/json'
                },
                credentials: "same-origin"
            }).then(function(response) {
                if (response.ok) {
                    return Promise.resolve(response)
                } else {
                    return Promise.reject(new Error(response.statusText))
                }
            }).then(function(response) {
                return response.json();
            }).then(function(data) {
                appendNewProject(data);
            });

        }

        function appendNewProject(new_project) {

            forEach(new_project, function (index, elem) {             

                projectsContainer.appendChild(elem);

            });

        }

        setTimeout(function() {
            initProjects();
        }, 300);

    }

}