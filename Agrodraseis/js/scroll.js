let lastScrollTop = 0;
const header = document.querySelector('.site-header');

window.addEventListener('scroll', () => {
  const currentScroll = window.pageYOffset || document.documentElement.scrollTop;

  if (currentScroll > lastScrollTop && currentScroll > 100) {
    // Scroll down → απόκρυψη header
    header.classList.add('hide');
  } else {
    // Scroll up → εμφάνιση header
    header.classList.remove('hide');
  }

  lastScrollTop = currentScroll <= 0 ? 0 : currentScroll; // ασφαλής επαναφορά
});
