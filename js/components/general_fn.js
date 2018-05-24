var domReady = function (callback) {
    document.readyState === "interactive" || document.readyState === "complete" ? callback() : document.addEventListener("DOMContentLoaded", callback);
};

var docEl = document.documentElement, html = document.getElementsByTagName("html")[0], body = document.body, docHeight, docWidth, fontSize, font, introCalled = false, rippleRunning = false, firstLoad = true, analyticsInit = false;

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
    docHeight = docEl.clientHeight;
    docWidth = docEl.clientWidth;
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

function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? parseInt(result[1], 16) + ',' + parseInt(result[2], 16) + ',' + parseInt(result[3], 16) : null;
}

function removeSpinner() {
    if (firstLoad) {
        body.classList.remove('is_loading');
    }
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
            }, false);
        }
    });

    if (triggerEvent && !triggerEvent.classList.contains('is_active') && triggerEvent.parentElement.getAttribute('id') !== 'contenitore_bottone_cookie') {
        triggerEvent.classList.add('is_active');
    }
}

////// load analytics //////////////

function loadAnalytics() {
    var analyticsScript = document.createElement("script");
    analyticsScript.src = baseUrl + '/js/build/analytics' + (isDev ? '.js' : '.min.js');
    document.body.appendChild(analyticsScript);
    window.removeEventListener("load", loadAnalytics, false);
}

////// scroll to top //////////////

function goTop(scrollDistance, duration) {
    anime({
        targets: document.querySelector('.barba-container'),
        scrollTop: scrollDistance,
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
            docEl.style.setProperty('--bkg', currentColor);
            document.querySelector('[name="theme-color"]').setAttribute('content', currentColor);
            ctx.fillStyle = currentColor;
            ctx.fill();
        }
    }
});