var colorChange = document.getElementById("color_change");
var ctx = colorChange.getContext("2d");
var cH;
var cW;
var animations = [];
var circles = [];
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
    var l = Math.max(x - 0, cW - x);
    var h = Math.max(y - 0, cH - y);
    return Math.sqrt(Math.pow(l, 2) + Math.pow(h, 2));
}

function handleEvent(e) {
    if (e.touches) { 
        e.preventDefault();
        e = e.touches[0];
    }
    currentColor = colorPicker.current();
    nextColor = colorPicker.next();
    var targetR = calcPageFillRadius(e.pageX, e.pageY);
    var rippleSize = Math.min(200, (cW * .4));
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
        duration:  Math.max(targetR / 2 , minCoverDuration ),
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
    if (this.stroke) {
        ctx.strokeStyle = this.stroke.color;
        ctx.lineWidth = this.stroke.width;
        ctx.stroke();
    }
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
        ctx.fillRect(0, 0, cW, cH);
        animations.forEach(function(anim) {
            anim.animatables.forEach(function(animatable) {
                animatable.target.draw();
            });
        });
    }
});

var resizeCanvas = function() {
    cW = docWidth;
    cH = docHeight;
    colorChange.width = cW * devicePixelRatio;
    colorChange.height = cH * devicePixelRatio;
    ctx.scale(devicePixelRatio, devicePixelRatio);
};

(function init() {
    resizeCanvas();
    window.addEventListener("resize", resizeCanvas);
    handleInactiveUser();
})();

function handleInactiveUser() {
    var inactive = setTimeout(function(){
        fauxClick(cW/2, cH/2);
    }, 2000);

    function clearInactiveTimeout() {
        clearTimeout(inactive);
        document.removeEventListener("mousedown", clearInactiveTimeout);
        document.removeEventListener("touchstart", clearInactiveTimeout);
    }

    document.addEventListener("mousedown", clearInactiveTimeout);
    document.addEventListener("touchstart", clearInactiveTimeout);
}

function fauxClick(x, y) {
    var fauxClick = new Event("mousedown");
    fauxClick.pageX = x;
    fauxClick.pageY = y;
    document.dispatchEvent(fauxClick);
}

function Particle( x, y, radius ) {
    this.init( x, y, radius );
}

Particle.prototype = {

    init: function( x, y, radius ) {

        this.alive = true;

        this.radius = radius || 10;
        this.wander = 0.15;
        this.theta = random( TWO_PI );
        this.drag = 0.92;
        this.color = '#fff';

        this.x = x || 0.0;
        this.y = y || 0.0;

        this.vx = 0.0;
        this.vy = 0.0;
    },

    move: function() {

        this.x += this.vx;
        this.y += this.vy;

        this.vx *= this.drag;
        this.vy *= this.drag;

        this.theta += random( -0.5, 0.5 ) * this.wander;
        this.vx += sin( this.theta ) * 0.1;
        this.vy += cos( this.theta ) * 0.1;

        this.radius *= 0.96;
        this.alive = this.radius > 0.5;
    },

    draw: function( ctx ) {

        ctx.beginPath();
        ctx.arc( this.x, this.y, this.radius, 0, TWO_PI );
        ctx.fillStyle = this.color;
        ctx.fill();
    }
};