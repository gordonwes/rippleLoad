/////// Pjax //////////////////

function initBarba() {

    Barba.Pjax.init();
    Barba.Prefetch.init();

    var exitDuration = 150,
        introDuration = 400,
        delayIntro = 250,
        easing = 'easeInOutQuad';

    var MovePage = Barba.BaseTransition.extend({
        start: function() {
            Promise
                .all([this.newContainerLoading, this.fadeOutPage()])
                .then(this.fadeInPage.bind(this));
        },

        fadeOutPage: function() {
            var deferred = Barba.Utils.deferred();
            var fadeOutPage = anime({
                targets: this.oldContainer,
                opacity: ['1', '0'],
                duration: exitDuration,
                easing: easing,
                complete: function() {
                    deferred.resolve();
                }
            });
            return deferred.promise;
        },

        fadeInPage: function() {
            this.done();
            var newWrap = this.newContainer;
            newWrap.style.opacity = '0';
            newWrap.style.visibility = 'visible';
            var fadeInPage = anime({
                targets: this.newContainer,
                opacity: ['0', '1'],
                delay: delayIntro,
                duration: introDuration,
                easing: easing
            });
        }

    });

    Barba.Pjax.getTransition = function() {
        return MovePage;
    };

    Barba.Dispatcher.on('newPageReady', function(currentStatus, prevStatus, HTMLElementContainer, newPageRawHTML) {
        initPages(HTMLElementContainer);
    });

    Barba.Pjax.originalPreventCheck = Barba.Pjax.preventCheck;

    Barba.Pjax.preventCheck = function(evt, element) {
        if (!Barba.Pjax.originalPreventCheck(evt, element)) {
            return false;
        }

        if (rippleRunning) {
            forEach(document.querySelectorAll('a.project_link, header ul a'), function (index, elem) {
                elem.addEventListener('click', function(e) {
                    e.preventDefault();
                }, false);
            });
            return false;
        }

        return true;
    };

    Barba.Dispatcher.on('linkClicked', function(HTMLElement, MouseEvent) {

        if (!rippleRunning) {

            handleEvent(MouseEvent);

            if (HTMLElement.classList.contains('project_link')) {
                var projectsVoice = document.querySelector('[href="' + baseUrl + '/projects"]');
                setMenuVoice(projectsVoice);
            } else if (HTMLElement.classList.contains('home_link')) {
                var homeVoice = document.querySelector('[href="' + baseUrl + '/"]');
                setMenuVoice(homeVoice);
            } else {
                setMenuVoice(HTMLElement);
            }

            document.documentElement.style.setProperty('--bkg', nextColor);
            document.querySelector('[name="theme-color"]').setAttribute('content', nextColor);
        
        }

    });

    var actualUrl = window.location.href, url;

    if (actualUrl.substring(actualUrl.length - 1, actualUrl.length) === '#') {
        url = actualUrl.substring(0, actualUrl.length - 1);
    } else {
        url = actualUrl;
    }

    setMenuVoice(document.querySelector('[href="' + url + '"]'));

}