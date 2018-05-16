var colorChange = document.getElementById("color_change"),
    ctx = colorChange.getContext("2d"),
    currentColor, nextColor, indexColor, fillAnimation;

var minCoverDuration = 650;

var colorPicker = (function () {

    forEach(colors, function (index, elem) {
        if (elem === firstColor) {
            indexColor = index;
        }
    });

    function next() {
        indexColor = indexColor++ < colors.length - 1 ? indexColor : 0;
        return colors[indexColor];
    }

    function current() {
        return colors[indexColor]
    }
    return {
        next: next,
        current: current
    }
})();

function calcPageFillRadius(x, y) {

    var l = Math.max(x - 0, docWidth - x);
    var h = Math.max(y - 0, docHeight - y);

    return Math.sqrt(Math.pow(l, 2) + Math.pow(h, 2)) + 10;

}

function handleEvent(e) {

    if (e.touches) {
        e.preventDefault();
        e = e.touches[0];
    }

    currentColor = colorPicker.current();
    nextColor = colorPicker.next();
    var targetR = calcPageFillRadius(e.pageX, e.pageY);
    var animDuration = Math.max(targetR / 2, minCoverDuration);

    var pageFill = new Circle({
        x: e.pageX,
        y: e.pageY,
        r: 0,
        fill: nextColor
    });

    fillAnimation = anime({
        targets: pageFill,
        r: targetR,
        duration: animDuration,
        easing: "easeInOutCirc",
        begin: function () {
            animate.play();
            rippleRunning = true;
        },
        complete: function () {
            firstColor = pageFill.fill;
            animate.pause();
            rippleRunning = false;
        }
    });

}

function extend(a, b) {
    for (var key in b) {
        if (b.hasOwnProperty(key)) {
            a[key] = b[key];
        }
    }
    return a;
}

var Circle = function (opts) {
    extend(this, opts);
}

Circle.prototype.draw = function () {
    //ctx.globalAlpha = 1;
    ctx.beginPath();
    ctx.arc(this.x, this.y, this.r, 0, 2 * Math.PI, false);
    if (this.fill) {
        ctx.fillStyle = this.fill;
        ctx.fill();
    }
    ctx.closePath();
}

var animate = anime({
    duration: Infinity,
    autoplay: false,
    update: function (anim) {

        ctx.fillStyle = firstColor;
        ctx.fillRect(0, 0, docWidth, docHeight);

        if (fillAnimation != null) {
            fillAnimation.animatables.forEach(function (animatable) {
                animatable.target.draw();                
            });
        }

    }
});

function resizeCanvas() {

    animate.restart();
    setTimeout(function () {
        animate.pause();
    }, 50);

    docWidth = document.documentElement.clientWidth;
    docHeight = document.documentElement.clientHeight;

    colorChange.width = docWidth * devicePixelRatio;
    colorChange.height = docHeight * devicePixelRatio;
    ctx.scale(devicePixelRatio, devicePixelRatio);
};

resizeCanvas();
window.addEventListener("resize", resizeCanvas, false);
