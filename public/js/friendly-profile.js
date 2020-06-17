const Canvas = document.getElementById("canvas1");
const ctx = Canvas.getContext("2d");
Canvas.width = window.innerWidth;
Canvas.height = window.innerHeight;

let particlesArray;

//*? get mouse position and behavior
let mouse = {
    x: null,
    y: null,
    radius: (Canvas.height / 120) * (Canvas.width / 120)
};
window.addEventListener("mousemove", function(event) {
    mouse.x = event.x;
    mouse.y = event.y;
});
//*!  particles class

class particles {
    constructor(x, y, directionX, directionY, size, color) {
        this.x = x;
        this.y = y;
        this.directionX = directionX;
        this.directionY = directionY;
        this.size = size;
        this.color = color;
    }
    //*! drawing the particles
    draw() {
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.size, 0, 2 * Math.PI, false);
        ctx.fillStyle = "#002147";
        ctx.fill();
    }
    //*!the behavior of the particles
    //* draw-check and move the particles
    update() {
        //*the particle doesn't go out
        if (this.x >= Canvas.width || this.x <= 0) {
            this.directionX = -this.directionX;
        }
        if (this.y >= Canvas.width || this.y <= 0) {
            this.directionY = -this.directionY;
        }
        //* mouse collision with the particles
        let dx = mouse.x - this.x;
        let dy = mouse.y - this.y;
        var distance = Math.sqrt(dx * dx + dy * dy);
        if (distance < this.size + mouse.radius) {
            if (mouse.x < this.x && this.x < Canvas.width - this.size * 10) {
                this.x += 10;
            }
            if (mouse.x > this.x && this.x > Canvas.width - this.size * 10) {
                this.x -= 10;
            }
            if (mouse.y < this.y && this.y < Canvas.width - this.size * 10) {
                this.y += 10;
            }
            if (mouse.y > this.y && this.y > Canvas.width - this.size * 10) {
                this.x -= 10;
            }
        }
        //*move particle
        this.x += this.directionX;
        this.y += this.directionY;

        this.draw();
    }
}

// !creation of alot of particles
function init() {
    particlesArray = [];
    let numberofParticles = (Canvas.height * Canvas.width) / 42000;
    for (let i = 0; i <= numberofParticles; i++) {
        let size = Math.random() * 2 + 1;
        let x = Math.random() * (innerWidth - size * 2 - size * 2) + size * 2;
        let y = Math.random() * (innerHeight - size * 2 - size * 2) + size * 2;
        let directionX = Math.random() * 2.5 - 3;
        let directionY = Math.random() * 2.5 - 3;
        let color = "5956b7";
        particlesArray.push(
            new particles(x, y, directionX, directionY, size, color)
        );
    }
}
// !animation loop
function animate() {
    requestAnimationFrame(animate);
    ctx.clearRect(0, 0, innerWidth, innerHeight);
    for (let i = 0; i < particlesArray.length; i++) {
        particlesArray[i].update();
    }
    connect();
}
//!connect particle if needed
function connect() {
    let opacityValue = 1;
    for (let i = 0; i < particlesArray.length; i++) {
        for (let j = i; j < particlesArray.length; j++) {
            let distance =
                (particlesArray[i].x - particlesArray[j].x) *
                (particlesArray[i].x - particlesArray[j].x) +
                (particlesArray[i].y - particlesArray[j].y) *
                (particlesArray[i].y - particlesArray[j].y);
            if (distance < (Canvas.width / 7) * (Canvas.height / 7)) {
                opacityValue = 1 - distance / 20000;
                ctx.strokeStyle = "rgba(111,111,111," + opacityValue + ")";
                ctx.beginPath();
                ctx.lineWitdh = 1;
                ctx.moveTo(particlesArray[i].x, particlesArray[i].y);
                ctx.lineTo(particlesArray[j].x, particlesArray[j].y);
                ctx.stroke();
            }
        }
    }
}
//! resize event
window.addEventListener("resize", function() {
    Canvas.width = innerWidth;
    Canvas.height = innerHeight;
    mouse.radius = (canvas.height / 80) * (canvas.width / 80);
    init();
});
//! mouse out event
window.addEventListener("mouseout", function() {
    mouse.x = undefined;
    mouse.y = undefined;
});
init();
animate();