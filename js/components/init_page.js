function initPages(page) {

    var actualPage = page.getAttribute('data-namespace');

    if (actualPage === 'projects') {

        var projectsContainer = page.querySelector('.container_projects');
        var scrollArea = page.querySelector('.vertical_align');
        var projects = page.querySelectorAll('.project');
        var totalProject = projects.length;
        var filters = page.querySelectorAll('.filters button');

        function initProjects(elems) {

            loadCover(elems);
            initFilter();

        }

        function loadCover(cover) {
            forEach(cover, function (index, elem) {
                var imgLoad = imagesLoaded(elem, {background: '.container_img'});
                imgLoad.on('always', function(instance) {
                    showProjectOnScroll(elem);
                });
            });
        }

        function showProjectOnScroll(elem) {

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

        function initFilter() {

            forEach(filters, function (index, elem) {

                setCountFilter(elem);

                elem.addEventListener('click', function(e) {

                    var filterValue = elem.getAttribute('data-filter');
                    elem.parentElement.querySelector('.is_checked').classList.remove('is_checked');
                    elem.classList.add('is_checked');

                    sortProjects(filterValue);

                });

            });

        }

        function setCountFilter(button) {

            var filterValue = button.getAttribute('data-filter');
            var filterCount = projectsContainer.querySelectorAll('[data-tag*="' + filterValue + '"]').length;
            
            var countContainer = button.nextElementSibling;

            if (filterValue !== '*') {
                countContainer.textContent = '( ' + filterCount + ' )';
            } else {
                countContainer.textContent = '( ' + totalProject + ' )';
            }

            var animCount = anime({
                targets: button.parentElement,
                opacity: ['0', '1'],
                duration: 200,
                easing: 'easeInOutQuad'
            });

        }

        function sortProjects(filterValue) {

            forEach(projects, function (index, elem) {

                

            });

        }

        setTimeout(function() {
            initProjects(projects);
        }, 300);

    }

}