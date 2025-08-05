document.addEventListener('DOMContentLoaded', function () {
  aplicarPreferencias();
});

window.darkMode = function (element) {
  const isDark = element.checked;
  localStorage.setItem('modoOscuro', isDark ? 'true' : 'false');
  document.body.classList.toggle('dark-version', isDark);
};

window.sidebarType = function (button) {
  const tipo = button.getAttribute('data-class');
  localStorage.setItem('sidebarColor', tipo);

  const sidebar = document.getElementById('sidenav-main');
  if (sidebar) {
    sidebar.className = sidebar.className.replace(/bg-\S+/g, tipo);
  }
};

window.navbarFixed = function (element) {
  const isFixed = element.checked;
  localStorage.setItem('navbarFixed', isFixed ? 'true' : 'false');

  const navbar = document.getElementById('navbarBlur');
  if (navbar) {
    navbar.classList.toggle('position-sticky', isFixed);
  }
};

function aplicarPreferencias() {
  // Modo oscuro
  const modoOscuro = localStorage.getItem('modoOscuro') === 'true';
  document.body.classList.toggle('dark-version', modoOscuro);
  const darkToggle = document.getElementById('dark-version');
  if (darkToggle) darkToggle.checked = modoOscuro;

  // Color barra lateral
  const sidebarColor = localStorage.getItem('sidebarColor');
  const sidebar = document.getElementById('sidenav-main');
  if (sidebar && sidebarColor) {
    sidebar.className = sidebar.className.replace(/bg-\S+/g, sidebarColor);
  }

  // Navbar fija
  const navbarFixedState = localStorage.getItem('navbarFixed') === 'true';
  const navbar = document.getElementById('navbarBlur');
  if (navbar) {
    const classes = ["position-sticky", "blur", "shadow-blur", "mt-4", "left-auto", "top-1", "z-index-sticky"];
    if (navbarFixedState) {
      navbar.classList.add(...classes);
      navbar.setAttribute("navbar-scroll", "true");
    } else {
      navbar.classList.remove(...classes);
      navbar.setAttribute("navbar-scroll", "false");
    }
    navbarBlurOnScroll("navbarBlur");
  }

}

window.addEventListener('load', aplicarPreferencias);

