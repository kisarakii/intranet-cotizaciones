// Cierra el offcanvas cuando se hace click en cualquier link dentro.
document.addEventListener('DOMContentLoaded', () => {
  const offcanvasEl = document.getElementById('offcanvasMain');
  if (!offcanvasEl) return;

  offcanvasEl.addEventListener('click', (e) => {
    const target = e.target.closest('a.nav-link, a.dropdown-item');
    if (!target) return;

    const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl) || new bootstrap.Offcanvas(offcanvasEl);
    offcanvas.hide();
  });
});
