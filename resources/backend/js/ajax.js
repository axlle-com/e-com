'use strict'

// Load css and js plugins
App.loadPlugins = (plugins, scripts) => {
  // Collect loaded plugins
  const loadedLink = [...document.head.querySelectorAll('link[href]')].map(i => i.getAttribute('href'))
  const loadedScript = [...document.head.querySelectorAll('script[data-src]')].map(i => i.getAttribute('data-src'))

  // Functions
  const isCSS = url => url.substring(url.lastIndexOf('.') + 1).split('?')[0] === 'css'
  function createLink(href) {
    return new Promise((resolve, reject) => {
      let tag = document.createElement('link')
      tag.rel = 'stylesheet'
      tag.href = href
      tag.onload = () => resolve()
      tag.onerror = () => reject(`Failed to load: ${href}`)
      document.getElementById('main-css').before(tag) // write link tags just before main style so as not to override the main style
    })
  }
  function createScript(src, text, remove = false) {
    let tag = document.createElement('script')
    tag.text = text
    tag.dataset.src = src
    remove ? document.head.appendChild(tag).parentNode.removeChild(tag) : document.head.appendChild(tag)
  }

  let loaded1 = [] // css
  let loaded2 = [] // js plugin
  let loaded3 = [] // js script

  let jsPlugins = []
  if (plugins) {
    // css -> directly generate link
    plugins.filter(i => isCSS(i) && !loadedLink.includes(i)).map(url => loaded1.push(createLink(url)))

    // js -> get all the contents
    jsPlugins = plugins.filter(i => !isCSS(i) && !loadedScript.includes(i))
    jsPlugins.map(url => loaded2.push(fetch(url).then(res => res.text())))
  } else {
    loaded1.push(Promise.resolve())
    loaded2.push(Promise.resolve())
  }

  if (scripts) {
    // script -> get all the contents
    scripts.map(url => loaded3.push(fetch(App.addTimestamp(url)).then(res => res.text())))
  } else {
    loaded3.push(Promise.resolve())
  }

  return Promise.all(loaded1)
  .then(() => Promise.all(loaded2))
  .then(text => jsPlugins.map((src, i) => createScript(src, text[i]))) // generate js plugins
  .then(() => Promise.all(loaded3))
  .then(text => scripts && scripts.map((src, i) => createScript(src, text[i], true))) // generate js scripts
}

// Show ajax loader
App.startLoading = () => {
  ajaxloader.classList.add('loading')
  setTimeout(() => {
    if (ajaxloader.classList.contains('loading')) {
      ajaxloader.style.display = ''
      setTimeout(() => ajaxloader.classList.add('show'), 10)
    }
  }, 500) // if the content doesn't appear in half a second (500 ms), then display the loader
}

// Stop ajax loader
App.stopLoading = () => {
  ajaxloader.style.display = 'none'
  ajaxloader.classList.remove('loading','show')
}

/*
when you initiate a plugin on a page and then leave to another page,
it may leave elements that need to be cleaned up manually before loading new page
*/
App.cleanScraps = () => {
  // remove all tags written by some plugins (popover, datepicker, limiterBox..)
  let ajaxJs = document.getElementById('ajax-js')
  let otherTags = []
  while (ajaxJs = ajaxJs.nextElementSibling) {
    ajaxJs.tagName.toLowerCase() != 'script' && otherTags.push(ajaxJs)
  }
  otherTags.map(i => i.parentNode.removeChild(i))
}

// Run script from text content
App.contentEval = content => {
  const d = document.createElement('div')
  d.innerHTML = content
  // Run script tags
  for (let code of d.querySelectorAll('script')) {
    let script = buildElement('script', code)
    document.head.appendChild(script).parentNode.removeChild(script)
  }
  // Create element with all it's attributes & content
  function buildElement(tag, src) {
    const el = document.createElement(tag)
    src.text && (el.text = src.text)
    const attrs = src.attributes
    if (attrs.length) {
      for (let attr of attrs) {
        el.setAttribute(attr.nodeName, attr.nodeValue)
      }
    }
    return el
  }

  return content.replace(/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi, "")
}

App.addTimestamp = (url) => {
  if (url.indexOf('_=') !== -1) {
    return url
  } else {
    const sign = url.indexOf('?') !== -1 ? '&' : '?'
    return url + sign + '_=' + Date.now()
  }
}

// Load url to content
App.loadURL = (url, currentLink, config) => {
  const container = document.querySelector(config.container)
  App.startLoading()
  fetch(App.addTimestamp(url)).then(response => {
    response.text().then(text => {
      // scroll to top
      if (document.querySelector('.main-navbar') && App.lgUp()) {
        const headerHeight = document.querySelector('.main-header').getBoundingClientRect().height
        if (window.scrollY >= headerHeight) {
          window.scrollTo(0, headerHeight)
        }
      } else {
        window.scrollTo(0, 0)
      }

      if (response.ok) {
        App.cleanScraps()
        if (config.breadcrumb) {
          let breadcrumb = App.generateBreadcrumb(currentLink, config)
          breadcrumb && (text = breadcrumb + text)
        }
        container.innerHTML = App.contentEval(text)
        document.body.classList.remove('inner-expand') // close inner expand
        // autofocus
        const autofocusEl = container.querySelector('[autofocus]')
        autofocusEl && autofocusEl.focus()
      } else {
        App.stopLoading()
        container.innerHTML = '<div class="alert alert-danger alert-error-load" role="alert">' + text + '</div>'
      }
    })
  })
}

// Get all parent nodes of given element
App.currentLinkParents = currentLink => {
  let target = currentLink
  let parent = []
  while (target) {
    // Get only nav-link
    if (target.classList.contains('nav-item')) parent.unshift(target.querySelector('.nav-link'))
    // Stop on treeview
    if (target.classList.contains('treeview')) break
    target = target.parentNode
  }
  return parent
}

// Update active menu based on 'current module'
App.updateMenu = currentLink => {
  document.querySelectorAll('#menu .active').forEach(i => i.classList.remove('active', 'show'))

  for (const i of App.currentLinkParents(currentLink)) {
    i.classList.add('active')
    i.classList.contains('treeview-toggle') && i.classList.add('show')
  }

  // for 'md down' devices, close sidebar after link clicked
  (App.mdDown() && document.body.classList.contains('sidebar-expand')) && document.querySelector('[data-toggle="sidebar"]').click()
}

// Update active menu to Top navigation
App.updateMenuTop = currentLink => {
  document.querySelector('.main-navbar').querySelectorAll('.active').forEach(i => i.classList.remove('active'))

  currentLink.classList.add('active')

  // Add .active .show to toggler if currentLink is sub
  if (!currentLink.classList.contains('nav-link')) {
    currentLink.closest('.nav-item').querySelector('.nav-link').classList.add('active')
  }
}

// Get original menu name (clean <i>, <svg>, <span>)
App.originalMenuName = dirty => {
  return dirty
    .replace(/<i.*>.*?<\/i>/ig, '')
    .replace(/<span.*>.*?<\/span>/ig, '')
    .replace(/<svg.*>.*?<\/svg>/ig, '').trim()
}

// Generate breadcrumb
App.generateBreadcrumb = (currentLink, config) => {
  if (currentLink.dataset.breadcrumb !== 'false') {
    let item = [`<li class="breadcrumb-item"><a href="#${config.default}">Home</a></li>`]

    const parents = App.currentLinkParents(currentLink)

    for (const parent of parents) {
      const parentName = App.originalMenuName(parent.innerHTML)

      if (parent.classList.contains('treeview-toggle')) {
        item.push(`<li class="breadcrumb-item"><a href="javascript:void(0)">${parentName}</a></li>`)
      } else {
        item.push(`<li class="breadcrumb-item active" aria-current="page">${parentName}</li>`)
      }
    }

    return `
      <nav aria-label="breadcrumb" class="main-breadcrumb">
        <ol class="breadcrumb">
          ${item.join('\n')}
        </ol>
      </nav>`;
  }
}

// App ajax function
App.ajax = (config) => {
  const url = location.href.split('#').splice(1).join('#')

  if (url) {
    const currentLink = menu.querySelector('a[href="#' + (url.split('?')[0]).split('/')[0] + '"]')

    // load url to container
    App.loadURL(url + window.location.search, currentLink, config)

    // Update active menu
    currentLink && App.updateMenu(currentLink)
    if (document.querySelector('.main-navbar')) {
      const currentLink2 = document.querySelector('.main-navbar a[href="#' + (url.split('?')[0]).split('/')[0] + '"]')
      currentLink2 && App.updateMenuTop(currentLink2)
    }

    // change page title from global var
    document.title = currentLink
      ? App.originalMenuName(currentLink.innerHTML)
      : document.title

  } else {
    // Load default url
    window.location.hash = menu.querySelector('a[href="#' + config.default + '"]').getAttribute('href')
  }

  // run on hash change
  window.onhashchange = () => App.ajax(config)

  // reload ajax
  App.ajaxReload = () => {
    App.ajax(config)
  }

  // reload on #refreshPage button clicked
  if (document.querySelector('#refreshPage')) {
    refreshPage.onclick = (e) => {
      App.ajaxReload()
      e.preventDefault()
    }
  }
}
