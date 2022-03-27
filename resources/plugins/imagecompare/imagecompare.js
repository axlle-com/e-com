const imagecompare = container => {
  const comparator = container.querySelector('.comparator')
  const divider = container.querySelector('.divider')

  comparator.querySelector('img').style.width = container.offsetWidth + 'px'

  let moveWidth = 0

  const getPageX = (e) => {
    if (e.pageX || e.targetTouches[0].pageX) {
      return e.pageX || e.targetTouches[0].pageX
    } else if (typeof e.originalEvent !== 'undefined') {
      return e.originalEvent.targetTouches[0].pageX
    } else {
      return false
    }
  }

  const moveSlide = e => {
    let pageX = getPageX(e)
    if (pageX !== false) {
      moveWidth = ((pageX - container.getBoundingClientRect().left) - 1) * 100 / container.offsetWidth + '%'
      divider.style.left = moveWidth
      comparator.style.width = moveWidth
    }
  }

  // Bind events to container
  container.addEventListener('mousemove', moveSlide)
  container.addEventListener('touchmove', moveSlide)

  window.addEventListener('resize', () => container.querySelector('.comparator img').style.width = container.offsetWidth + 'px')
}
