export default function (el) {
  const previousElementTheme = el.previousElementSibling.getAttribute('data-theme')
  if (previousElementTheme) {
    el.setAttribute('data-theme', previousElementTheme)
  }
}
