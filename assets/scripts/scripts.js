document.addEventListener("DOMContentLoaded", function () {
  // Query all dropdown elements (both custom-select and dropdown)
  const dropdowns = document.querySelectorAll('.custom-select, .dropdown')

  dropdowns.forEach(function (dropdown) {
    // Determine trigger element based on type
    let trigger
    if (dropdown.classList.contains('custom-select')) {
      trigger = dropdown.querySelector('.custom-select-trigger')
    } else {
      trigger = dropdown.querySelector('.dropdown-header')
    }
    if (!trigger) return

    // Set placeholder for filter dropdowns if not already set
    if (dropdown.classList.contains('dropdown') && !dropdown.hasAttribute('data-placeholder')) {
      dropdown.setAttribute('data-placeholder', trigger.textContent.trim())
    }

    // Toggle dropdown on trigger click
    trigger.addEventListener('click', function (e) {
      console.log('Custom-select trigger clicked:', trigger)
      e.stopPropagation()
      // Close other dropdowns before toggling this one
      dropdowns.forEach(d => {
        if (d !== dropdown) d.classList.remove('open')
      })
      dropdown.classList.toggle('open')
    })

    // Handle language switcher (custom-select) options
    if (dropdown.classList.contains('custom-select')) {
      const options = dropdown.querySelectorAll('.custom-option')
      options.forEach(function (option) {
        option.addEventListener('click', function (e) {
          e.stopPropagation()
          const value = this.getAttribute('data-value')
          const text = this.textContent.trim()
          trigger.textContent = text
          dropdown.classList.remove('open')
          if (value) {
            window.location.href = value
          }
        })
      })
    }

    // Handle filter dropdowns with checkboxes
    if (dropdown.classList.contains('dropdown')) {
      const checkboxes = dropdown.querySelectorAll('input[type="checkbox"]')
      if (checkboxes.length > 0) {
        checkboxes.forEach(function (checkbox) {
          checkbox.addEventListener('change', function () {
            const selected = []
            checkboxes.forEach(cb => {
              if (cb.checked) {
                const label = cb.closest('label')
                if (label) {
                  selected.push(label.textContent.trim())
                }
              }
            })
            // Update trigger text: if selections exist, show them; otherwise reset to placeholder.
            if (selected.length > 0) {
              trigger.textContent = selected.join(', ')
            } else {
              trigger.textContent = dropdown.getAttribute('data-placeholder')
            }
          })
        })
      }
    }
  })

  // Close any open dropdown when clicking outside
  document.addEventListener('click', function (e) {
    dropdowns.forEach(function (dropdown) {
      if (!dropdown.contains(e.target)) {
        dropdown.classList.remove('open')
      }
    })
  })
})