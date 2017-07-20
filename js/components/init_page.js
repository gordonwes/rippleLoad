function initPages(page) {

    var actual_page = page.getAttribute('data-namespace');

    if (actual_page === 'contact') {

        console.log('contatti');

    } else if (actual_page === 'projects') {

        var projectsContainer = page.querySelector('.container_projects');
        var scrollArea = page.querySelector('.vertical_align');
        var projects = page.querySelectorAll('.project');
        var filterCount = page.querySelector('.count');
        var projectsLoaded = false;
        var infProject, loadAll;

        setTimeout(function() {

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
                updateFilterCount();
            });

            initFilters();
            showProjectOnScroll(projects);
            updateFilterCount();

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

                updateFilterCount();
            });

        }

        function filterProject(filterValue) {

            clearInterval(loadAll);

            var updateProject = page.querySelectorAll('.project');

            if (filterValue !== '*') {

                forEach(updateProject, function (index, elem) {

                    elem.classList.remove('is_filtered');
                    elem.classList.add('is_hidden');

                    if (elem.classList.contains(filterValue)) {
                        elem.classList.add('is_filtered');
                    }

                });

            } else {

                forEach(updateProject, function (index, elem) {

                    elem.classList.remove('is_filtered');
                    elem.classList.remove('is_hidden');

                });

            }

        }

        function updateFilterCount() {



        }

        function preloadAllPages(filterValue) {

<<<<<<< HEAD
            if (!projectsLoaded) {
                loadAll = setInterval(function(){
                    if (infProject.loadCount !== 2) {
                        projectsLoaded = false;
                        infProject.loadNextPage();
                    } else {
                        filterProject(filterValue);
                        projectsLoaded = true;
                        console.log('andato');
                    }
                }, 50);
            } else {
                filterProject(filterValue);
            }
=======
            loadAll = setInterval(function(){
                if (infProject.loadCount !== projectPage) {
                    infProject.loadNextPage();
                } else {
                    filterProject(filterValue);
                }
            }, 50);
>>>>>>> f9a375bfacac590827a624311bc52906e3086a53

        }

    }

}