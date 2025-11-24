const counters = document.querySelectorAll('.counter');

const animateCounter = (el) => {
  const target = +el.getAttribute('data-target');
  let current = 0;
  const increment = target / 100;

  const index = Array.from(counters).indexOf(el);
  const suffix = (index === counters.length - 1) ? '%' : '+';

  const update = () => {
    current += increment;
    if (current < target) {
      el.textContent = Math.ceil(current) + suffix;
      requestAnimationFrame(update);
    } else {
      el.textContent = target + suffix;
    }
  };
  update();
};

// Observer για επαναληπτική μέτρηση
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.textContent = '0';
      animateCounter(entry.target);
    }
  });
}, { threshold: 0.6 });

counters.forEach(counter => observer.observe(counter));
