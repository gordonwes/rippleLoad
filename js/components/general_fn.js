var domReady = function (callback) {
    document.readyState === "interactive" || document.readyState === "complete" ? callback() : document.addEventListener("DOMContentLoaded", callback);
};

var body = document.body, docHeight, docWidth, html, fontSize, font, introCalled = false, rippleRunning = false, analyticsInit = false;

/////// prevent scroll on touch  //////////////////

function deactiveTM(e) {
    e.preventDefault();
}

function preventTM() {
    body.addEventListener("touchmove", deactiveTM, false);
}

function restoreTM() {
    body.removeEventListener("touchmove", deactiveTM, false);
}

/////// requestAnimationFrame polyfill  //////////////////

(function () {
    var lastTime = 0;

    var vendors = ['ms', 'moz', 'webkit', 'o'];
    for (var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
        window.requestAnimationFrame = window[vendors[x] + 'RequestAnimationFrame'];
        window.cancelAnimationFrame = window[vendors[x] + 'CancelAnimationFrame']
        || window[vendors[x] + 'CancelRequestAnimationFrame'];
    }

    if (!window.requestAnimationFrame)
        window.requestAnimationFrame = function (callback, element) {
            var currTime = new Date().getTime();
            var timeToCall = Math.max(0, 16 - (currTime - lastTime));
            var id = window.setTimeout(function () {
                callback(currTime + timeToCall);
            },
                                       timeToCall);
            lastTime = currTime + timeToCall;
            return id;
        };

    if (!window.cancelAnimationFrame)
        window.cancelAnimationFrame = function (id) {
            clearTimeout(id);
        };
}());

//// general measure //////

function calcSizeViewport() {
    docHeight = document.documentElement.clientHeight;
    docWidth = document.documentElement.clientWidth;
    html = document.getElementsByTagName("html")[0],
        fontSize = window.getComputedStyle(html),
        font = parseInt(fontSize.getPropertyValue('font-size'));
}

calcSizeViewport();
window.addEventListener('resize', function() {
    requestAnimationFrame(calcSizeViewport);
}, false);

var isMobile = docWidth <= 1024;

/////// rapid function //////////////////

var forEach = function (array, callback, scope) {
    for (var i = 0; i < array.length; i++) {
        callback.call(scope, i, array[i]);
    }
};

////// match word ////////////////

function wordInString(s, word) {
    return new RegExp('\\b' + word + '\\b', 'i').test(s);
}

////// capitalize first letter //////////////

function capitalizeFirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

////// set active menu voice //////////////

function setMenuVoice(triggerEvent) {
    forEach(document.querySelectorAll('header nav a'), function (index, elem) {
        if (elem.classList.contains('is_active')) {
            elem.classList.remove('is_active');
        }
        if (elem.getAttribute('href') == window.location.href && !elem.classList.contains('no-barba')) {
            elem.addEventListener('click', function(e) {
                e.preventDefault();
            });
        }
    });

    if (triggerEvent && !triggerEvent.classList.contains('is_active')) {
        triggerEvent.classList.add('is_active');
    }
}

////// load analytics //////////////

function loadAnalytics() {
    var analyticsScript = document.createElement("script");
    analyticsScript.src = baseUrl + '/js/build/analytics' + (isDev ? '.js' : '.min.js');
    document.body.appendChild(analyticsScript);
}

////// scroll to top //////////////

function goTop(elemScroll, duration) {
    anime({
        targets: document.querySelector(elemScroll),
        scrollTop: 0,
        duration: duration,
        easing: 'easeInOutQuad'
    });
}

////// detect back/forward button for change active menu //////////////

window.addEventListener('popstate', function (e) {
    var state = e.state;
    if (state === null) {
        var linkNow = document.querySelector('[href="' + window.location.href + '"]');
        if (linkNow) {
            setMenuVoice(linkNow);
            document.documentElement.style.setProperty('--bkg', nextColor);
        }
    }
});