// Minimal UI interactions: mobile menu toggle and modal helper
window.AppUI = {
  toggleMobileMenu(menuId){
    const el = document.getElementById(menuId);
    if(!el) return;
    el.classList.toggle('hidden');
  }
}
