//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@    ANALYTICS    @@@@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//

var htmlStyle = document.documentElement.style,
    isWebkit = 'WebkitAppearance' in htmlStyle,
    isChromium = !!window.chrome,
    isiOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream,
    isEdge = !!(window.CSS && window.CSS.supports('-ms-user-select', 'none')),
    isIEOld = ('msScrollLimit' in htmlStyle || 'behavior' in htmlStyle) && !isEdge,
    isIE9 = isIEOld && !'msUserSelect' in htmlStyle,
    isChrome = !!window.chrome && !!window.chrome.webstore,
    isFF = 'MozAppearance' in htmlStyle,
    isOpera = !!window.opera || /opera|opr/i.test(navigator.userAgent),
    isSafari = isWebkit && !isChrome && !isOpera,
    analyticsInit = true,
    device, browser;

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

var userLang = navigator.language || navigator.userLanguage; 

var deviceType = {
    'device': device,
    'browser': browser,
    'lang': userLang
}

var analyticsRequest = new XMLHttpRequest();

analyticsRequest.addEventListener("error", function() {
    console.log('error analytics');
}, false);

analyticsRequest.addEventListener("abort", function() {
    console.log('abort analytics');
}, false);

analyticsRequest.open('POST', baseUrl + '/track', true);

analyticsRequest.setRequestHeader("Content-type", 'application/json');

analyticsRequest.send(JSON.stringify(deviceType));