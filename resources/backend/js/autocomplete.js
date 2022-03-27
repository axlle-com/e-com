function autocomplete(inp, arr) {
  let currentFocus
  inp.addEventListener('input', function () {
    let a, b, i, val = this.value
    closeAllLists()
    if (!val) { return false }
    currentFocus = -1
    if (arr.filter(i => i.toUpperCase().startsWith(val.toUpperCase())).length) {
      a = document.createElement('div')
      a.setAttribute('id', this.id + 'autocomplete-list')
      a.setAttribute('class', 'dropdown-menu autocomplete-items show')
      this.insertAdjacentElement('afterend', a)
      const inpMb = window.getComputedStyle(inp).marginBottom.replace('px', '')
      const menuMt = window.getComputedStyle(a).marginTop.replace('px', '')
      a.style.marginTop = -(inpMb - menuMt) + 'px'
      // Prevent the default mousedowm, which ensures the input is not blurred.
      a.addEventListener('mousedown', e => e.preventDefault())
      for (i = 0; i < arr.length; i++) {
        // check if the item starts with the same letters as the text field value
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          b = document.createElement('a')
          b.setAttribute('class', 'dropdown-item')
          b.setAttribute('href', '#')
          b.setAttribute('tabindex', '-1')
          b.innerHTML = `<strong>${arr[i].substr(0, val.length)}</strong>`
          b.innerHTML += arr[i].substr(val.length)
          b.innerHTML += `<input type="hidden" value="${arr[i]}">`
          // Prevent the default mousedowm, which ensures the input is not blurred.
          b.addEventListener('mousedown', e => e.preventDefault())
          b.addEventListener('click', function (e) {
            inp.value = this.getElementsByTagName('input')[0].value
            closeAllLists()
            e.preventDefault()
          })
          a.appendChild(b)
        }
      }
    }
  })
  // execute a function presses a key on the keyboard
  inp.addEventListener('keydown', function (e) {
    var x = document.getElementById(this.id + 'autocomplete-list')
    if (x) x = x.getElementsByTagName('a')
    if (e.keyCode == 40) { // arrow down
      currentFocus++
      addActive(x)
    } else if (e.keyCode == 38) { // arrow up
      currentFocus--
      addActive(x)
    } else if (e.keyCode == 13) { // enter
      if (currentFocus > -1) {
        if (x) x[currentFocus].click()
      }
      e.preventDefault()
    }
  })
  function addActive(x) {
    if (!x) return false
    removeActive(x)
    if (currentFocus >= x.length) currentFocus = 0
    if (currentFocus < 0) currentFocus = (x.length - 1)
    x[currentFocus].classList.add('active')
  }
  function removeActive(x) {
    [...x].map(i => i.classList.remove('active'))
  }
  function closeAllLists(target) {
    [...document.getElementsByClassName('autocomplete-items')].map(el => target != el && target != inp ? el.remove() : '')
  }
  document.addEventListener('click', e => closeAllLists(e.target))
}
