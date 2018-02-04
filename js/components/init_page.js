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
            limitX: isMobile ? 16 : 6,
            limitY: isMobile <= 1024 ? 4 : 2,
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
                    var pageScroll = page.scrollTop;
                    if (pageScroll > 10) {
                        goTop('.barba-container', 600);
                    }
                    containerIntro.classList.remove('detail_active');
                    var exitMore = anime({
                        targets: moreContent,
                        delay: pageScroll > 10 ? 300 : 0,
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

            imgLoad.on('progress', function(instance, image) {
                showProjectOnScroll(image.element.parentElement);
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
                        opacity: {
                            value: ['0', '1'],
                            duration: 350,
                            easing: 'linear'
                        },
                        translateY: { 
                            value: ['1.5rem', '0'],
                            duration: 500,
                            easing: 'easeInOutQuad'
                        },
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
                        var parentElem = elem.parentElement.parentElement,
                            parentFixed = parentElem.classList.contains('fixed');
                        parentElem.querySelector('.is_checked').classList.remove('is_checked');
                        elem.classList.add('is_checked');
                        if (parentFixed) {
                            goTop('.barba-container', 600);
                        }
                        if (!parentFixed && page.scrollTop > 5) {
                            goTop('.barba-container', 80);
                        }
                        sortProjects(filterValue);
                    }

                });

            });

        }

        function setCountFilter(button) {

            var filterValue = button.getAttribute('data-filter'),
                filterCount = projectsContainer.querySelectorAll('[data-tag*="' + filterValue + '"]').length,
                countContainer = button.nextElementSibling;

            countContainer.textContent = '( ' + (filterValue !== '*' ? filterCount : totalProject) + ' )';

            var animCount = anime({
                targets: button.parentElement.parentElement,
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
                        if (elem.querySelector('[data-tag*="' + filterValue + '"]')) {
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
                container = page.querySelector('.container_fn_project'),
                containerMoreScroll = page.querySelector('.container_more_scroll'),
                containerScrollFilter = elem.querySelector('.container_filters'),
                moreScrollDx = page.querySelector('.container_more_scroll .scroll_dx'),
                moreScrollSx = page.querySelector('.container_more_scroll .scroll_sx');

            if (nextColor !== 'undefined') {
                elem.style.backgroundColor = nextColor;
                moreScrollSx.style.backgroundImage = 'linear-gradient(to right, ' + nextColor + ' 55%, rgba(255,255,255,0) 100%)';
                moreScrollDx.style.backgroundImage = 'linear-gradient(to left, ' + nextColor + ' 55%, rgba(255,255,255,0) 100%)';
                moreScrollSx.style.backgroundImage = '-webkit-linear-gradient(right, ' + nextColor + ' 55%, rgba(255,255,255,0) 100%)';
                moreScrollDx.style.backgroundImage = '-webkit-linear-gradient(left, ' + nextColor + ' 55%, rgba(255,255,255,0) 100%)';
                moreScrollSx.style.backgroundImage = '-moz-linear-gradient(to right, ' + nextColor + ' 55%, rgba(255,255,255,0) 100%)';
                moreScrollDx.style.backgroundImage = '-moz-linear-gradient(to left, ' + nextColor + ' 55%, rgba(255,255,255,0) 100%)';
            }

            function setMoreFilterInit() {

                if (containerScrollFilter.scrollWidth > docWidth - (1.5 * font)) {

                    containerMoreScroll.classList.add('active');
                    //containerMoreScroll.style.left = elem.scrollLeft + 'px';

                    var isFixedMenu = page.scrollTop > heightNavFilter;
                    var varFixed = isFixedMenu ? '0' : (3 * font);

                    if (containerScrollFilter.scrollLeft > 0) {
                        moreScrollSx.classList.add('active');
                    } else {
                        moreScrollSx.classList.remove('active');
                    }
                    if (containerScrollFilter.scrollLeft + docWidth - varFixed >= containerScrollFilter.scrollWidth) {
                        moreScrollDx.classList.remove('active');
                    } else {
                        moreScrollDx.classList.add('active');
                    }

                } else {
                    containerMoreScroll.classList.remove('active');
                }

            }

            setMoreFilterInit();
            window.addEventListener('resize', setMoreFilterInit);
            containerScrollFilter.addEventListener('scroll', setMoreFilterInit);

            function triggerFixedFilter() {

                var scrollTop = page.scrollTop;
                wScrollDiff = wScrollBefore - scrollTop;

                if (scrollTop > heightNavFilter) {

                    elem.classList.add('fixed');

                    setTimeout(function() {
                        elem.classList.add('hide_it'); 
                    }, 20);

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
                    elem.classList.remove('hide_it');

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

            triggerFixedFilter();
            page.addEventListener('scroll', requestTickFixedFilter);

        }

        setTimeout(function() {
            initProjects(projects);
            if (isMobile) {
                filtersMobile(filter);
            }
        }, 300);

    }

    if ((actualPage === 'about-me' || actualPage === 'projects') && !analyticsInit) {
        window.addEventListener("load", loadAnalytics, false);
    }

}