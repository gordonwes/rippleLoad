function initPages(page) {

    var actual_page = page.getAttribute('data-namespace');

    if (actual_page === 'contact') {


    } else if (actual_page === 'projects') {

        var projectsContainer = page.querySelector('.container_projects');
        var scrollArea = page.querySelector('.vertical_align');
        var projects = page.querySelectorAll('.project');
        var filterCount = page.querySelector('.count');
        var projectsLoaded = false;
        var infProject, loadAll;

        function initListProjects() {

            infProject = new InfiniteScroll(projectsContainer, {
                path: function() {
                    if (this.loadCount < projectPage) {
                        var nextIndex = this.loadCount + 2;
                        return './app/projects/projects_list_0' + nextIndex + '.php';
                    }
                },
                append: '.project',
                elementScroll: scrollArea,
                prefill: true,
                history: false,
                status: '.projects_status'
            });

            infProject.on('append', function(response, path, items) {
                showProjectOnScroll(items);
                if (page.querySelector('.button.is_checked').getAttribute('data-filter') === '*') {
                    updateFilterCount('*');
                }
            });

            initFilters();
            showProjectOnScroll(projects);
            updateFilterCount('*');

        }

        setTimeout(function() {
            initListProjects();
        }, 300);


        function showProjectOnScroll(projectArray) {

            forEach(projectArray, function (index, elem) {

                if (!elem.classList.contains('is_hidden')) {

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

                }

            });

        }

        function initFilters() {

            var filters = page.querySelector('.filters');

            filters.addEventListener('click', function(event) {
                if ( !matchesSelector(event.target, 'button')) {
                    return;
                }
                var filterValue = event.target.getAttribute('data-filter');

                preloadAllPages(filterValue);

                filters.querySelector('.is_checked').classList.remove('is_checked');
                event.target.classList.add('is_checked');

            });

        }

        function filterProject(filterValue) {

            clearInterval(loadAll);

            var updateProject = page.querySelectorAll('.project');

            if (filterValue !== '*') {

                forEach(updateProject, function (index, elem) {

                    elem.classList.remove('is_filtered');
                    elem.classList.add('is_hidden');

                    if (elem.querySelector('[data-tag="' + filterValue + '"]')) {
                        elem.classList.add('is_filtered');
                    }

                });

            } else {

                forEach(updateProject, function (index, elem) {

                    elem.classList.remove('is_filtered');
                    elem.classList.remove('is_hidden');

                });

            }

            updateFilterCount(filterValue);

        }

        function updateFilterCount(filterValue) {

            if (docWidth > 767) {

                var containerCount = page.querySelector('.container_count span');

                if (filterValue !== '*') {
                    var totalCount = page.querySelectorAll('[data-tag="' + filterValue + '"]').length;
                } else {
                    var totalCount = page.querySelectorAll('.project').length;
                }

                if (totalCount !== 0) {

                    containerCount.textContent = totalCount;

                }

            }

        }

        function preloadAllPages(filterValue) {

            if (!projectsLoaded) {
                loadAll = setInterval(function(){
                    if (infProject.loadCount !== projectPage) {
                        projectsLoaded = false;
                        infProject.loadNextPage();
                    } else {
                        filterProject(filterValue);
                        projectsLoaded = true;
                    }
                }, 50);
            } else {
                filterProject(filterValue);
            }

        }

        function initDetailProject() {

            forEach(projects, function (index, elem) {

                elem.addEventListener('click', function() {



                });

            });

        }

    } else if (actual_page === 'login') {

        function errorLogin() {

            if (wordInString(window.location.href, 'error=true')) {
                page.querySelector('.container_login').classList.add('incorrect_login');
            }

        }

        errorLogin();

    } else if (actual_page === '404') {

        setMenuVoice(document.querySelector('[href="' + window.location.href + '"]'));

    } 

}