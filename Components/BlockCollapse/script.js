export default function(el) {
  console.log(el.previousElementSibling)
  const previousElementTheme = el.previousElementSibling.getAttribute('data-theme')
  if (previousElementTheme) {
    el.setAttribute('data-theme', previousElementTheme)
  }
}
