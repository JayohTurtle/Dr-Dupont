
const links = document.querySelectorAll('.nav-link')

links.forEach(link => {
  if (link.href === window.location.href) {
    link.style.color = '#90CAF9'
  }
})
