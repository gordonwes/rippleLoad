var colorChange = document.getElementById("color_change");
var ctx = colorChange.getContext("2d");
var animations = [];
var currentColor, nextColor, indexColor;

var colorPicker = (function() {

    forEach(colors, function (index, elem) {
        if (elem === firstColor) {
            indexColor = index;
        }
    });

    function next() {
        indexColor = indexColor++ < colors.length-1 ? indexColor : 0;
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

function removeAnimation(animation) {
    var index = animations.indexOf(animation);
    if (index > -1) animations.splice(index, 1);
}

function calcPageFillRadius(x, y) {

    // var extraRadius = 0;

    var l = Math.max(x - 0, docWidth - x);
    var h = Math.max(y - 0, docHeight - y);

    /*if (localStorage.getItem('radiusValue')) {

        var oldWidth = localStorage.getItem('radiusValue');

        if (oldWidth == docHeight) {

            // orientation change
            extraRadius = 200;
            localStorage.setItem('radiusValue', docWidth);

        }

    } else {

        localStorage.setItem('radiusValue', docWidth);

    }*/

    return Math.sqrt(Math.pow(l + extraRadius, 2) + Math.pow(h + extraRadius, 2));

    //  return Math.sqrt(Math.pow(l, 2) + Math.pow(h, 2));

}

function handleEvent(e) {
    if (e.touches) {
        e.preventDefault();
        e = e.touches[0];
    }
    currentColor = colorPicker.current();
    nextColor = colorPicker.next();
    var targetR = calcPageFillRadius(e.pageX, e.pageY);

    var minCoverDuration = 750;

    var pageFill = new Circle({
        x: e.pageX,
        y: e.pageY,
        r: 0,
        fill: nextColor
    });

    var fillAnimation = anime({
        targets: pageFill,
        r: targetR,
        duration:  Math.max(targetR / 2 , minCoverDuration),
        easing: "easeOutQuart",
        complete: function(){
            firstColor = pageFill.fill;
            removeAnimation(fillAnimation);
        }
    });

    animations.push(fillAnimation);
}

function extend(a, b){
    for(var key in b) {
        if(b.hasOwnProperty(key)) {
            a[key] = b[key];
        }
    }
    return a;
}

var Circle = function(opts) {
    extend(this, opts);
}

Circle.prototype.draw = function() {
    ctx.globalAlpha = this.opacity || 1;
    ctx.beginPath();
    ctx.arc(this.x, this.y, this.r, 0, 2 * Math.PI, false);
    if (this.fill) {
        ctx.fillStyle = this.fill;
        ctx.fill();
    }
    ctx.closePath();
    ctx.globalAlpha = 1;
}

var animate = anime({
    duration: Infinity,
    update: function() {
        ctx.fillStyle = firstColor;
        ctx.fillRect(0, 0, docWidth, docHeight);
        animations.forEach(function(anim) {
            anim.animatables.forEach(function(animatable) {
                animatable.target.draw();
            });
        });
    }
});

function resizeCanvas() {
    colorChange.width = docWidth * devicePixelRatio;
    colorChange.height = docHeight * devicePixelRatio;
    ctx.scale(devicePixelRatio, devicePixelRatio);
};

resizeCanvas();
window.addEventListener("resize", resizeCanvas);