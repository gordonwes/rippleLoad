function initPages(page) {

    var actual_page = page.getAttribute('data-namespace');

    if (actual_page === 'contact') {

        console.log('contatti');

    } else if (actual_page === 'projects') {

        var projectsContainer = page.querySelector('.container_projects');

        setTimeout(function() {
            var infProject = new InfiniteScroll(projectsContainer, {
                path: './app/projects/projects_list_0{{#}}.php',
                append: '.project',
                prefill: true,
                history: false,
                status: '.projects_status',
                //debug: true,
                onInit: function() {
                    this.on('load', function() {
                        var isoProject = new Isotope(projectsContainer, {
                            itemSelector: '.project',
                            getSortData: {
                                website: '.website',
                                graphic: '.graphic',
                                native: '.native'
                            }
                        });

                        var sortByGroup = page.querySelector('.filter');
                        sortByGroup.addEventListener('click', function(e) {
                            // only button clicks
                            if (!matchesSelector(e.target, '.button')) {
                                return;
                            }
                            var sortValue = e.target.getAttribute('data-sort-value');
                            isoProject.arrange({ sortBy: sortValue });
                        });

                        var buttonGroups = document.querySelectorAll('.filter');
                        for ( var i=0; i < buttonGroups.length; i++ ) {
                            buttonGroups[i].addEventListener('click', onButtonGroupClick );
                        }

                        function onButtonGroupClick(e) {
                            // only button clicks
                            if ( !matchesSelector(e.target, '.button') ) {
                                return;
                            }
                            var button = e.target;
                            button.parentNode.querySelector('.is-checked').classList.remove('is-checked');
                            button.classList.add('is-checked');
                        } 
                    });
                }
            });
        }, 600);

    }

}