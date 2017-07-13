function initPages(page) {

    var actual_page = page.getAttribute('data-namespace');

    if (actual_page === 'contact') {

        console.log('contatti');

    } else if (actual_page === 'projects') {

        var projectsContainer = page.querySelector('.container_projects');
        var scrollArea = page.querySelector('.vertical_align');
        var projects = page.querySelectorAll('.project');
        var infProject;

        setTimeout(function() {

            infProject = new InfiniteScroll(projectsContainer, {
                path: './app/projects/projects_list_0{{#}}.php',
                append: '.project',
                elementScroll: scrollArea,
                prefill: true,
                history: false,
                status: '.projects_status'
            });

            infProject.on('append', function(response, path, items) {
                initFilters(items);
                showProjectOnScroll(items);
            });

            initFilters(projects);
            showProjectOnScroll(projects);

        }, 300);

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

        function initFilters(projectArray) {

            var filters = page.querySelectorAll('.filters button');

            forEach(filters, function (index, elem) {

                elem.addEventListener('click', function(e) {
                    e.preventDefault();

                    forEach(filters, function (index, elem) {
                        elem.classList.remove('is_checked');
                    });

                    elem.classList.add('is_checked');

                    var filterValue = elem.getAttribute('data-sort-value');

                    forEach(projectArray, function (index, elem) {

                        elem.classList.remove('visible_block');
                        elem.classList.remove('filtered');

                        var projectTag = elem.getAttribute('data-tag');

                        if (filterValue !== '*') {

                            elem.classList.add('visible_block');
                            elem.classList.add('hidden');

                            if (wordInString(projectTag.toString(), filterValue)) {
                                elem.classList.add('filtered');
                            }

                        } else {
                            elem.classList.remove('hidden');
                            elem.classList.remove('visible_block');
                        }

                    });

                    if (page.querySelector('.container_projects').offsetHeight < docHeight - 100) {
                        infProject.loadNextPage();
                        setTimeout(function() {
                            forEach(page.querySelectorAll('.project'), function (index, elem) {
                                elem.classList.add('visible_block');
                                elem.classList.remove('filtered');

                                var projectTag = elem.getAttribute('data-tag');

                                if (filterValue !== '*') {

                                    elem.classList.add('hidden');

                                    if (wordInString(projectTag.toString(), filterValue)) {
                                        elem.classList.add('filtered');
                                    }

                                } else {
                                    elem.classList.remove('hidden');
                                }
                            });
                        }, 300);
                    }

                });


            });

        }






    }

}