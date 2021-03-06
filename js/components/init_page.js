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

        function setInitialMessage() {
            if (introduction) {
                var actualTime = new Date().getHours();
                if (actualTime >= 5 && actualTime < 18) {
                    introduction.textContent = 'Buongiorno! ';
                } else {
                    introduction.textContent = 'Buonasera! ';
                }
            }
        }

        function initMovingHand() {
            var parallax = new Parallax(emoji, {
                calibrateX: true,
                limitX: isMobile ? 16 : 6,
                limitY: isMobile ? 4 : 2,
                scalarX: 20,
                scalarY: 20,
                invertX: false,
                invertY: false
            });
        }

        function fadeInAbout() {
            if (!introCalled) {
                var introAnim = anime({
                    targets: page,
                    opacity: ['0', '1'],
                    delay: 200,
                    duration: 400,
                    easing: 'easeInOutQuad',
                    begin: removeSpinner
                });
                introCalled = true;
            }
        }

        function showMoreContent(e) {
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
                        begin: function () {
                            moreContent.style.display = 'block';
                            runningMore = true;
                        },
                        complete: function () {
                            moreOpen = true;
                            runningMore = false;
                        }
                    });
                } else {
                    moreButton.textContent = 'MORE +';
                    var pageScrollGap = page.scrollTop > 10;
                    if (pageScrollGap) {
                        goTop(0, 600);
                    }
                    containerIntro.classList.remove('detail_active');
                    var exitMore = anime({
                        targets: moreContent,
                        delay: pageScrollGap ? 300 : 0,
                        opacity: ['1', '0'],
                        translateY: ['0', '1.5rem'],
                        duration: 300,
                        easing: 'easeInOutQuad',
                        begin: function () {
                            runningMore = true;
                        },
                        complete: function () {
                            moreOpen = false;
                            moreContent.style.display = 'none';
                            runningMore = false;
                        }
                    });
                }
            }
        }

        function initAbout() {
            setInitialMessage();
            initMovingHand();
            fadeInAbout();
            moreButton.addEventListener('click', function (e) {
                showMoreContent(e);
            }, false);
        }

        initAbout();

    }

    if (actualPage === 'projects') {

        var projectsContainer = page.querySelector('.container_projects'),
            projects = page.querySelectorAll('.project'),
            totalProject = projects.length,
            filter = page.querySelector('.filters'),
            filters = page.querySelectorAll('.filters button'),
            backTop = page.querySelector('.end_list a'),
            changedFilterProject = false,
            istancePackery;

        function initProjects(elems) {

            removeSpinner();

            if (docWidth > 500) {
                istancePackery = new Packery(projectsContainer, {
                    itemSelector: '.project',
                    percentPosition: true,
                    transitionDuration: 0
                });

                istancePackery.layout();
            }

            forEach(elems, function (index, elem) {
                showProjectOnScroll(elem, index);
            });

            initFilter();

            setTimeout(function () {
                detectVisibilityGoTop(backTop);
            }, !changedFilterProject ? 200 : 0);

        }

        function detectCoverLoad(elem, index) {

            var imgLoad = imagesLoaded(elem, {
                background: '.container_img'
            });

            imgLoad.on('always', function (instance, image) {
                elem.classList.add('bkg_loaded');
                sessionStorage.setItem('img_loaded_' + index, 'true');
            });

        }

        function showProjectOnScroll(elem, index) {

            var tickProject = false,
                imgLoaded = sessionStorage.getItem('img_loaded_' + index);

            if (imgLoaded) {
                elem.classList.add('istant_load');
                elem.classList.add('bkg_loaded');
            }

            if (docWidth > 500 && changedFilterProject) {
                istancePackery.layout();
            }

            function setAnimationElem() {

                var projectTop = elem.getBoundingClientRect().top;

                if (projectTop - docHeight < tiggerShowPrj && !elem.classList.contains('in_viewport')) {
                    var animProject = anime({
                        targets: elem,
                        opacity: {
                            value: ['0', '1'],
                            duration: 350,
                            easing: 'easeInOutQuad'
                        },
                        translateY: {
                            value: ['1.5rem', '0'],
                            duration: 500,
                            easing: 'easeInOutQuad'
                        },
                        begin: function () {
                            elem.classList.add('in_viewport');
                        },
                        complete: function () {
                            if (!imgLoaded) {
                                detectCoverLoad(elem, index);
                            }
                            page.removeEventListener('scroll', requestTickProject, false);
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

            setTimeout(function () {
                setAnimationElem();
            }, !changedFilterProject ? 600 : 0);
            page.addEventListener('scroll', requestTickProject, false);

        }

        function initFilter() {

            forEach(filters, function (index, elem) {

                setCountFilter(elem);

                elem.addEventListener('click', function (e) {

                    var filterValue = elem.getAttribute('data-filter');

                    function setActiveFilter(elem, parentElem, filterValue) {
                        parentElem.querySelector('.is_checked').classList.remove('is_checked');
                        elem.classList.add('is_checked');
                        sortProjects(filterValue);
                    }

                    if (!elem.classList.contains('is_checked')) {

                        var parentElem = elem.parentElement.parentElement,
                            parentFixed = parentElem.classList.contains('fixed');

                        if (parentFixed) {
                            goTop(0, 400);
                            setTimeout(function () {
                                setActiveFilter(elem, parentElem, filterValue);
                            }, 400);
                        } else {
                            if (page.scrollTop > 5) {
                                goTop(0, 100);
                                setTimeout(function () {
                                    setActiveFilter(elem, parentElem, filterValue);
                                }, 100);
                            } else {
                                setActiveFilter(elem, parentElem, filterValue);
                            }
                        }

                        changedFilterProject = true;

                    }

                }, false);

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
                begin: function () {
                    hideEndList();
                },
                complete: function () {
                    initFiltering();
                }
            });

            function initFiltering() {

                forEach(projects, function (index, elem) {

                    elem.classList.add('is_hidden');
                    elem.classList.remove('in_viewport');
                    elem.style.opacity = '0';

                    if (filterValue !== '*') {
                        if (elem.querySelector('[data-tag*="' + filterValue + '"]')) {
                            elem.classList.remove('is_hidden');
                        }
                    } else {
                        elem.classList.remove('is_hidden');
                    }

                    showProjectOnScroll(elem, index);

                });

                setTimeout(function () {
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
                var nextColorAlpha = hexToRgb(nextColor);
                moreScrollSx.style.backgroundImage = 'linear-gradient(to right, ' + nextColor + ' 55%, rgba(' + nextColorAlpha + ', 0) 100%)';
                moreScrollDx.style.backgroundImage = 'linear-gradient(to left, ' + nextColor + ' 55%, rgba(' + nextColorAlpha + ', 0) 100%)';
            }

            function setMoreFilterInit() {

                if (containerScrollFilter.scrollWidth > docWidth - (1.5 * font)) {

                    containerMoreScroll.classList.add('active');

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
            window.addEventListener('resize', setMoreFilterInit, false);
            containerScrollFilter.addEventListener('scroll', setMoreFilterInit, false);

            function triggerFixedFilter() {

                var scrollTop = page.scrollTop;
                wScrollDiff = wScrollBefore - scrollTop;

                if (scrollTop > heightNavFilter) {

                    elem.classList.add('fixed');

                    setTimeout(function () {
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
            page.addEventListener('scroll', requestTickFixedFilter, false);

        }

        initProjects(projects);
        if (isMobile) {
            filtersMobile(filter);
        }

    }

    if (actualPage === 'privacy-policy') {
        removeSpinner();
    }

    if (!analyticsInit) {
        window.addEventListener('load', loadAnalytics, false);
    }

}
