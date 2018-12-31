let Particle = function(radius) {
    this.x = this.y = this.dx = this.dy= 0;
    this.radius = radius;
    this.reset();
};

Particle.prototype.reset = function() {
    this.y = Math.random() * window.innerHeight;
    this.x = Math.random() * window.innerWidth;
    this.dx = (Math.random()) - 0.5;
    this.dy = (Math.random() * 0.5) + 0.5;
};

let snow = function() {
    // Vars
    let canvas;
    let ctx;
    let screenWidth = 0;
    let screenHeight = 0;
    let particles = [];
    let particleRadius = 5;


    // Event Listeners
    function onResize() {
        screenWidth  = canvas.width  = window.innerWidth;
        screenHeight = canvas.height = window.innerHeight;
        ctx = canvas.getContext('2d');

        createParticles((screenWidth * screenHeight) / 10000, particleRadius);
    }

    // Functions
    function createParticles(count, radius) {
        if (count !== particles.length) {
            particles = [];
            for (let i = 0; i < count; i++) {
                particles.push(new Particle(radius));
            }
        }
    }

    function updateParticles() {
        ctx.clearRect(0, 0, screenWidth, screenHeight);
        ctx.fillStyle = '#f6f9fa';

        particles.forEach(function(particle) {
            particle.y += particle.dy;
            particle.x += particle.dx;

            if (particle.y > screenHeight) {
                particle.y = 0;
            }

            if (particle.x > screenWidth) {
                particle.reset();
                particle.y = 0;
            }

            ctx.beginPath();
            ctx.arc(particle.x, particle.y, particle.radius, 0, Math.PI * 2, false);
            ctx.fill();
        });

        window.requestAnimationFrame(updateParticles);
    }

    function loader () {

    }

    // Init
    canvas = document.getElementById('snow');

    window.addEventListener('resize', onResize);
    onResize();

    // Start Update
    updateParticles();
};

export default snow;