function initPages(page) {

    var actual_page = page.getAttribute('data-namespace');

    initGeneral(page);

    window['init' + capitalizeFirst(actual_page)](page);

}