const starRating = (element, config = {}) => {
  if (!element) {
    return false
  }
  if (element.previousElementSibling && element.previousElementSibling.classList.contains('star-rating')) {
    element.previousElementSibling.remove()
  }
  const stars = 5
  element.setAttribute('hidden', true)
  element.value = element.value > stars ? stars : element.value
  const size = element.dataset.starRatingSize || config.size || 1.5
  const width = size * stars
  const initValue = (100 / stars) * element.value
  element.insertAdjacentHTML('beforebegin', `<div class="star-rating"><div class="star-rating-value" style="width: ${initValue}%" data-star-rating-width="${initValue}%"></div></div>`)
  const container = element.previousSibling
  const children = container.getElementsByClassName('star-rating-value')[0]

  container.style.width = width + 'em'
  container.style.height = size + 'em'
  container.style.backgroundSize = size + 'em'
  children.style.backgroundSize = size + 'em'
  element.readOnly && (container.style.cursor = 'auto')

  if (element.readOnly === false) {
    const getPercent = e => {
      const rect = e.target.getBoundingClientRect()
      let clientX = e.clientX
      if (clientX === undefined) {
        clientX = e.touches.length ? e.touches[0].clientX : e.changedTouches[0].clientX
      }
      const x = clientX - rect.left
      const percent = x / container.offsetWidth * 100
      return Math.ceil(Math.ceil(percent) / 10) * 10 + '%'
    }
    const setValue = () => {
      let newValue = children.dataset.starRatingWidth.replace('%', '') / (100 / stars)
      newValue = newValue < 0 ? 0 : (newValue > stars ? stars : newValue)
      if (element.value != newValue) {
        element.value = newValue
        element.setAttribute('value', newValue)
        element.dispatchEvent(new Event('change'))
      }
    }
    container.addEventListener('mousemove', e => children.style.width = getPercent(e))
    container.addEventListener('touchmove', e => children.style.width = getPercent(e))
    container.addEventListener('mouseleave', () => children.style.width = children.dataset.starRatingWidth)
    container.addEventListener('click', e => {
      children.dataset.starRatingWidth = getPercent(e)
      setValue()
    })
    container.addEventListener('touchend', e => {
      children.dataset.starRatingWidth = getPercent(e)
      setValue()
    })
  }
}
