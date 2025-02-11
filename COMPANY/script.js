// Intersection Observer for fade-in effect
document.addEventListener('DOMContentLoaded', function () {
  const fadeInElements = document.querySelectorAll('.fade-in');

  // Initialize intersection observer
  const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 }); // Adjust threshold to trigger when 10% of the element is in view

  // Observe each element with the fade-in class
  fadeInElements.forEach(element => {
    observer.observe(element);
  });
});
