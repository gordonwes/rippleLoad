function initPages(page) {

    var actualPage = page.getAttribute('data-namespace');

    if (actualPage === 'about-me') {

        var containerIntro = page.querySelector('.container_intro'),
            introduction = page.querySelector('.initial_hi'),
            emoji = page.querySelector('.move_it'),
            moreButton = page.querySelector('a.more'),
            moreContent = page.querySelector('span.more_content'),
            moreOpen = false,
            runningMore = false;

        if (introduction) {

            var actualTime = new Date().getHours();

            if (actualTime >= 5 && actualTime < 18) {
                introduction.textContent = 'Buongiorno! ';
            } else {
                introduction.textContent = 'Buonasera! ';
            }

        }

        var parallax = new Parallax(emoji, {
            calibrateX: true,
            limitX: 6,
            limitY: 2,
            scalarX: 20,
            scalarY: 20,
            invertX: false,
            invertY: false
        });

        if (!introCalled) {
            var introAnim = anime({
                targets: page,
                opacity: ['0', '1'],
                delay: 200,
                duration: 400,
                easing: 'easeInOutQuad'
            });
            introCalled = true;
        }

        moreButton.addEventListener('click', function(e) {
            e.preventDefault();
            if (!runningMore) {
                if (!moreOpen) {
                    moreButton.textContent = 'LESS -';
                    containerIntro.classList.add('detail_active');
                    var introMore = anime({
                        targets: moreContent,
                        opacity: ['0', '1'],
                        translateY: ['1.5rem', '0'],
                        duration: 400,
                        easing: 'easeInOutQuad',
                        begin: function() {
                            moreContent.style.display = 'block';
                            runningMore = true;
                        },
                        complete: function() {
                            moreOpen = true;
                            runningMore = false;
                        }
                    });
                } else {
                    moreButton.textContent = 'MORE +';
                    containerIntro.classList.remove('detail_active');
                    var exitMore = anime({
                        targets: moreContent,
                        opacity: ['1', '0'],
                        translateY: ['0', '1.5rem'],
                        duration: 300,
                        easing: 'easeInOutQuad',
                        begin: function() {
                            runningMore = true;
                        },
                        complete: function() {
                            moreOpen = false;
                            moreContent.style.display = 'none';
                            runningMore = false;
                        }
                    });                 
                }
            }
        });

    }

    if (actualPage === 'projects') {

        var projectsContainer = page.querySelector('.container_projects'),
            projects = page.querySelectorAll('.project'),
            totalProject = projects.length,
            filter = page.querySelector('.filters'),
            filters = page.querySelectorAll('.filters button'),
            backTop = page.querySelector('.end_list a');

        function initProjects(elems) {

            loadCover(elems);
            initFilter();
            detectVisibilityGoTop(backTop);

        }

        function loadCover(cover) {
            var imgLoad = imagesLoaded(cover, {background: '.container_img'});
            imgLoad.on('always', function(instance) {
                forEach(cover, function (index, elem) {
                    showProjectOnScroll(elem);
                });
            });
        }

        function showProjectOnScroll(elem) {

            var hiddenProject = true,
                tickProject = false;

            function setAnimationElem() {

                var projectTop = elem.getBoundingClientRect().top,
                    heightProject = elem.offsetHeight;

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

                tickProject = false;

            }

            function requestTickProject() {
                if (!tickProject) {
                    requestAnimationFrame(setAnimationElem);
                    tickProject = true;
                }
            }

            setAnimationElem();
            page.addEventListener('scroll', requestTickProject);

        }

        function initFilter() {

            forEach(filters, function (index, elem) {

                setCountFilter(elem);

                elem.addEventListener('click', function(e) {

                    var filterValue = elem.getAttribute('data-filter');

                    if (!elem.classList.contains('is_checked')) {
                        elem.parentElement.querySelector('.is_checked').classList.remove('is_checked');
                        elem.classList.add('is_checked');
                        if (elem.parentElement.classList.contains('fixed')) {
                            goTop('.barba-container');
                        }
                        sortProjects(filterValue);
                    }

                });

            });

        }

        function setCountFilter(button) {

            var filterValue = button.getAttribute('data-filter'),
                filterCount = projectsContainer.querySelectorAll('[data-tag~="' + filterValue + '"]').length,
                countContainer = button.nextElementSibling;

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

            var hideProjectsOut = anime({
                targets: projectsContainer,
                opacity: ['1', '0'],
                duration: 200,
                easing: 'easeInOutQuad',
                begin: function() {
                    hideEndList();
                },
                complete: function() {
                    initFiltering();
                }
            });

            function initFiltering() {

                forEach(projects, function (index, elem) {

                    elem.classList.add('is_hidden');
                    elem.style.opacity = '0';

                    if (filterValue !== '*') {
                        if (elem.querySelector('[data-tag~="' + filterValue + '"]')) {
                            elem.classList.remove('is_hidden');
                        }
                    } else {
                        elem.classList.remove('is_hidden');
                    }

                    showProjectOnScroll(elem);

                });

                setTimeout(function() {
                    projectsContainer.style.opacity = '1';    
                    showEndList();
                }, 30);

            }

            function hideEndList() {

                var hideBackTop = anime({
                    targets: backTop,
                    opacity: ['1', '0'],
                    duration: 200,
                    easing: 'easeInOutQuad'
                });

            }

            function showEndList() {

                var showBackTop = anime({
                    targets: backTop,
                    opacity: ['0', '1'],
                    duration: 400,
                    easing: 'easeInOutQuad'
                });

                detectVisibilityGoTop(backTop);

            }

        }

        function detectVisibilityGoTop(elem) {

            if (elem) {

                var elemTop = elem.getBoundingClientRect().top;

                if (elemTop > docHeight) {
                    elem.style.visibility = 'visible';
                } else {
                    elem.style.visibility = 'hidden'; 
                }

            }

        }

        function filtersMobile(elem) {

            var tickFilter = false,
                wScrollBefore = 0,
                wScrollDiff = 0,
                triggerDown = 0,
                triggerUp = 0,
                heightNavFilter = 6.2 * font,
                container = page.querySelector('.container_fn_project');

            function triggerFixedFilter() {

                var scrollTop = page.scrollTop;
                wScrollDiff = wScrollBefore - scrollTop;

                console.log(scrollTop);

                if (scrollTop > heightNavFilter) {

                    elem.classList.add('fixed');
                    container.style.paddingTop = heightNavFilter + 'px';

                    if (wScrollDiff > triggerUp) {

                        elem.classList.add('show_it');

                    } else if (wScrollDiff < triggerDown) {

                        elem.classList.remove('show_it');

                    }

                } else if (scrollTop <= 0) {

                    container.style.paddingTop = 0;
                    elem.classList.remove('fixed');
                    elem.classList.remove('show_it');

                }

                wScrollBefore = scrollTop;
                tickFilter = false;

            }

            function requestTickFixedFilter() {
                if (!tickFilter) {
                    requestAnimationFrame(triggerFixedFilter);
                    tickFilter = true;
                }
            }

            if (docWidth <= 1024) {
                triggerFixedFilter();
                page.addEventListener('scroll', requestTickFixedFilter);
            }

        }

        setTimeout(function() {
            initProjects(projects);
            filtersMobile(filter);
        }, 300);

    }

}