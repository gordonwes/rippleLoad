/////// Pjax //////////////////

function initBarba() {

    Barba.Pjax.init();
    Barba.Prefetch.init();

    var MovePage = Barba.BaseTransition.extend({
        start: function() {
            Promise
                .all([this.newContainerLoading, this.fadeOutPage()])
                .then(this.fadeInPage.bind(this));
        },

        fadeOutPage: function() {
            var deferred = Barba.Utils.deferred();
            var _this = this;
            var fadeOutPage = anime({
                targets: _this.oldContainer,
                opacity: ['1', '0'],
                duration: 150,
                easing: 'easeInOutQuad',
                complete: function() {
                    deferred.resolve();
                }
            });
            return deferred.promise;
        },

        fadeInPage: function() {
            this.done();
            this.newContainer.style.opacity = '0';
            this.newContainer.style.visibility = 'visible';
            var _this = this;
            var fadeInPage = anime({
                targets: this.newContainer,
                opacity: ['0', '1'],
                delay: 200,
                duration: 400,
                easing: 'easeInOutQuad'
            });
        }

    });

    Barba.Pjax.getTransition = function() {
        return MovePage;
    };

    Barba.Dispatcher.on('newPageReady', function(currentStatus, prevStatus, HTMLElementContainer, newPageRawHTML) {
        initPages(HTMLElementContainer);
    });

    Barba.Dispatcher.on('linkClicked', function(HTMLElement, MouseEvent) {
        handleEvent(MouseEvent);

        if (HTMLElement.classList.contains('project_link')) {
            var projectsVoice = document.querySelector('[href="' + baseUrl + '/projects"]');
            setMenuVoice(projectsVoice);
            if (!support_var) {
                projectsVoice.style.borderColor = nextColor;
            }
        } else if (HTMLElement.classList.contains('home_link')) {
            var homeVoice = document.querySelector('[href="' + baseUrl + '/"]');
            setMenuVoice(homeVoice);
            if (!support_var) {
                homeVoice.style.borderColor = nextColor;
            }
        } else {            
            setMenuVoice(HTMLElement);
            if (!support_var) {
                HTMLElement.style.borderColor = nextColor;
            }
        }

        if (support_var) {
            document.documentElement.style.setProperty('--bkg', nextColor);
        }

    });

    setMenuVoice(document.querySelector('[href="' + window.location.href + '"]'));

}