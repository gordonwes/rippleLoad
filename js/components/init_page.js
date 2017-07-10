function initPages(page) {

    var actual_page = page.getAttribute('data-namespace');

    initType(page);

    window['init' + capitalizeFirst(actual_page)](page);

}