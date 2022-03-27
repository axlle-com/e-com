const settingModal = `
<button style="position:fixed;top:156px;right:-.25rem;z-index:1029" type="button" class="btn has-icon btn-light shadow" data-toggle="modal" data-target="#settingModal"><i class="material-icons">settings</i></button>
<div class="modal fade modal-content-right" id="settingModal" tabindex="-1" role="dialog" aria-labelledby="settingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document" style="max-width:270px">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white shadow-none">
        <h6 class="modal-title" id="settingModalLabel">Settings</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <small class="d-block text-secondary">Navigation theme</small>
        <div class="custom-color custom-color-lg mt-2">
          <div class="color-item">
            <input type="radio" name="navigation-theme" value="../../css/sidebar-royal.min.css" id="navigation-theme-royal" class="custom-control-input" checked>
            <label class="rounded-circle" for="navigation-theme-royal" style="background-color:#243b55"></label>
          </div>
          <div class="color-item">
            <input type="radio" name="navigation-theme" value="../../css/sidebar-blue.min.css" id="navigation-theme-blue" class="custom-control-input">
            <label class="rounded-circle" for="navigation-theme-blue" style="background-color:#2b579a"></label>
          </div>
          <div class="color-item">
            <input type="radio" name="navigation-theme" value="../../css/sidebar-cyan.min.css" id="navigation-theme-cyan" class="custom-control-input">
            <label class="rounded-circle" for="navigation-theme-cyan" style="background-color:#006064"></label>
          </div>
          <div class="color-item">
            <input type="radio" name="navigation-theme" value="../../css/sidebar-green.min.css" id="navigation-theme-green" class="custom-control-input">
            <label class="rounded-circle" for="navigation-theme-green" style="background-color:#217346"></label>
          </div>
          <div class="color-item">
            <input type="radio" name="navigation-theme" value="../../css/sidebar-pink.min.css" id="navigation-theme-pink" class="custom-control-input">
            <label class="rounded-circle" for="navigation-theme-pink" style="background-color:#ad1457"></label>
          </div>
          <div class="color-item">
            <input type="radio" name="navigation-theme" value="../../css/sidebar-purple.min.css" id="navigation-theme-purple" class="custom-control-input">
            <label class="rounded-circle" for="navigation-theme-purple" style="background-color:#7151c8"></label>
          </div>
          <div class="color-item">
            <input type="radio" name="navigation-theme" value="../../css/sidebar-red.min.css" id="navigation-theme-red" class="custom-control-input">
            <label class="rounded-circle" for="navigation-theme-red" style="background-color:#b7472a"></label>
          </div>
          <div class="color-item">
            <input type="radio" name="navigation-theme" value="../../css/sidebar-dark.min.css" id="navigation-theme-dark" class="custom-control-input">
            <label class="rounded-circle" for="navigation-theme-dark" style="background-color:#272822"></label>
          </div>
          <div class="color-item color-item-light">
            <input type="radio" name="navigation-theme" value="../../css/sidebar-white.min.css" id="navigation-theme-white" class="custom-control-input">
            <label class="rounded-circle" for="navigation-theme-white" style="background-color:#fff"></label>
          </div>
          <div class="color-item">
            <input type="radio" name="navigation-theme" value="../../css/sidebar-gray.min.css" id="navigation-theme-gray" class="custom-control-input">
            <label class="rounded-circle" for="navigation-theme-gray" style="background-color:#37474f"></label>
          </div>
          <div class="color-item">
            <input type="radio" name="navigation-theme" value="../../css/sidebar-ash.min.css" id="navigation-theme-ash" class="custom-control-input">
            <label class="rounded-circle" for="navigation-theme-ash" style="background-color:#606c88"></label>
          </div>
          <div class="color-item">
            <input type="radio" name="navigation-theme" value="../../css/sidebar-crimson.min.css" id="navigation-theme-crimson" class="custom-control-input">
            <label class="rounded-circle" for="navigation-theme-crimson" style="background-color:#573662"></label>
          </div>
          <div class="color-item">
            <input type="radio" name="navigation-theme" value="../../css/sidebar-namn.min.css" id="navigation-theme-namn" class="custom-control-input">
            <label class="rounded-circle" for="navigation-theme-namn" style="background-color:#9b3333"></label>
          </div>
          <div class="color-item">
            <input type="radio" name="navigation-theme" value="../../css/sidebar-frost.min.css" id="navigation-theme-frost" class="custom-control-input">
            <label class="rounded-circle" for="navigation-theme-frost" style="background-color:#00275a"></label>
          </div>
        </div>
        <small class="d-block text-secondary mt-4 mb-2">Font family</small>
        <div class="btn-group-toggle btn-group-sm" data-toggle="buttons">
          <label class="btn btn-light active">
            <input type="radio" name="font-family-theme" value="../../../font/inter/inter.min.css" data-css="" checked> Inter
          </label>
          <label class="btn btn-light">
            <input type="radio" name="font-family-theme" value="../../../font/roboto/roboto.min.css" data-css="../../css/font-family-roboto.min.css"> Roboto
          </label>
        </div>
      </div>
    </div>
  </div>
</div>
`
document.body.insertAdjacentHTML('beforeend', settingModal)

// Transparent modal backdrop
$('#settingModal').on('show.bs.modal', () => {
  document.head.insertAdjacentHTML('beforeend', `
    <style id="tmp-style">.modal-backdrop.show{opacity:0}</style>
  `)
}).on('hidden.bs.modal', () => {
  document.querySelector('#tmp-style').remove()
})

// apply theme
function applyTheme(src) {
  let logo = src.includes('white') ? 'logo.svg' : 'logo-white.svg'
  document.querySelector('#main-logo').src = '../../img/' + logo
  document.querySelector('#theme-css').href = src
}
// apply font
function applyFont(src, css) {
  document.querySelector('#font-css').href = src
  if (src.includes('inter')) {
    document.querySelector('#font-family-css') && document.querySelector('#font-family-css').remove()
  } else {
    document.querySelector('#main-css').insertAdjacentHTML('afterend', `<link rel="stylesheet" href="${css}" id="font-family-css">`)
  }
}
// watch changes
document.addEventListener('change', e => {
  if (e.target.closest('input[name="navigation-theme"]')) {
    const el = e.target.closest('input[name="navigation-theme"]')
    applyTheme(el.value)
    sessionStorage.setItem('navigation-theme', el.value)
  }
})
document.addEventListener('click', e => {
  if (e.target.closest('input[name="font-family-theme"]')) {
    const el = e.target.closest('input[name="font-family-theme"]')
    applyFont(el.value, el.dataset.css)
    sessionStorage.setItem('font-family-theme', el.value)
  }
})
// init from session
if (sessionStorage.getItem('navigation-theme')) {
  document.querySelector('input[name="navigation-theme"][value="' + sessionStorage.getItem('navigation-theme') + '"]').checked = true
  applyTheme(sessionStorage.getItem('navigation-theme'))
}
if (sessionStorage.getItem('font-family-theme')) {
  document.querySelector('input[name="font-family-theme"][value="' + sessionStorage.getItem('font-family-theme') + '"]').click()
  setTimeout(() => {
    for (const el of document.querySelectorAll('input[name="font-family-theme"]:not(:checked)')) {
      el.closest('.btn').classList.remove('active')
    }
  }, 500)
}
