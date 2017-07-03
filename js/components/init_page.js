function initPages(page) {

    var actual_page = page.getAttribute('data-namespace');
    
    window['init' + capitalizeFirst(actual_page)](page);

}