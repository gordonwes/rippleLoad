//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@    ANALYTICS    @@@@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//

var htmlStyle = document.documentElement.style;

var isMobile = docWidth <= 1024;

var isWebkit = 'WebkitAppearance' in htmlStyle;

var isChromium = !!window.chrome;
var isiOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

var isEdge = !!(window.CSS && window.CSS.supports('-ms-user-select', 'none')),
    isIEOld = ('msScrollLimit' in htmlStyle || 'behavior' in htmlStyle) && !isEdge,
    isIE9 = isIEOld && !'msUserSelect' in htmlStyle;

var isChrome = !!window.chrome && !!window.chrome.webstore;

var isFF = 'MozAppearance' in htmlStyle;

var isOpera = !!window.opera || /opera|opr/i.test(navigator.userAgent);

var isSafari = isWebkit && !isChrome && !isOpera;

var device, browser;

if (isChromium && !isChrome && !isOpera && !isSafari && isMobile) {
    device = 'Android';
} else if (isiOS) {
    device = 'iOS';  
} else if (isMobile) {
    device = 'Mobile';  
} else {
    device = 'Desktop';
}

if (isEdge) {
    browser = 'Edge';
} else if (isIEOld || isIE9) {
    browser = 'IE';
} else if (isChrome) {
    browser = 'Chrome';
} else if (isFF) {
    browser = 'Firefox';
} else if (isOpera) {
    browser = 'Opera';
} else if (isSafari) {
    browser = 'Safari';
} else {
    browser = 'unknown';
}

var time = new Date(),
    visitedYear = time.getFullYear(),
    visitedMonth = time.getMonth(),
    visitedDay = time.getDate(),
    visitedHour = time.getHours();

var deviceType = {
    'device': device,
    'browser': browser,
    'dateY': visitedYear,
    'dateM': visitedMonth,
    'dateD': visitedDay,
    'dateH': visitedHour
}

var analyticsRequest = new XMLHttpRequest();

analyticsRequest.addEventListener("error", function() {
    console.log('error');
}, false);

analyticsRequest.addEventListener("abort", function() {
    console.log('abort');
}, false);

analyticsRequest.open('POST', baseUrl + '/track', true);

analyticsRequest.setRequestHeader("Content-type", 'application/json');

analyticsRequest.send(JSON.stringify(deviceType));