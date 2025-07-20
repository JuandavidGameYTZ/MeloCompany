// Sidebar toggle functionality
const toggleBtn = document.getElementById('menu-toggle');
const sidebar = document.getElementById('sidebar');
const body = document.body;

if (toggleBtn && sidebar) {
  // Toggle sidebar open/close on button click
  toggleBtn.addEventListener('click', () => {
    toggleBtn.classList.toggle('active');
    sidebar.classList.toggle('open');
    body.classList.toggle('sidebar-open');
  });

  // Close sidebar when Escape key is pressed
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && sidebar.classList.contains('open')) {
      sidebar.classList.remove('open');
      toggleBtn.classList.remove('active');
      body.classList.remove('sidebar-open');
    }
  });

  // Close sidebar when clicking outside of it
  document.addEventListener('click', (event) => {
    const isClickInsideSidebar = sidebar.contains(event.target);
    const isClickOnToggle = toggleBtn.contains(event.target);
    if (!isClickInsideSidebar && !isClickOnToggle && sidebar.classList.contains('open')) {
      sidebar.classList.remove('open');
      toggleBtn.classList.remove('active');
      body.classList.remove('sidebar-open');
    }
  });
}

// Profile dropdown functionality
const profileContainer = document.querySelector('.profile-container');
const profileDropdown = document.getElementById('profile-dropdown');

if (profileContainer && profileDropdown) {
  // Toggle dropdown on profile click
  profileContainer.addEventListener('click', (e) => {
    e.stopPropagation();
    profileDropdown.classList.toggle('open');
  });

  // Close dropdown when clicking outside
  document.addEventListener('click', (e) => {
    if (!profileDropdown.contains(e.target) && !profileContainer.contains(e.target)) {
      profileDropdown.classList.remove('open');
    }
  });

  // Close dropdown with Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      profileDropdown.classList.remove('open');
    }
  });
}

// Scroll buttons for horizontal containers
function scrollLeftBtn(id) {
  const container = document.getElementById(id);
  container.scrollBy({ left: -300, behavior: 'smooth' });
}

function scrollRightBtn(id) {
  const container = document.getElementById(id);
  container.scrollBy({ left: 300, behavior: 'smooth' });
}

// Detect mobile device and add class to body
(function() {
  const ua = navigator.userAgent || navigator.vendor || window.opera;
  const isAndroid = /Android/i.test(ua);
  const isIPhone = /iPhone|iPad|iPod/i.test(ua);

  if (isAndroid || isIPhone) {
    document.body.classList.add('mobile-device');
  }
})();

// Star rating functionality
document.querySelectorAll('.star-rating .star').forEach(star => {
  star.addEventListener('click', () => {
    const rating = star.getAttribute('data-star');
    const container = star.closest('.star-rating');
    const usuario = container.getAttribute('data-usuario');

    // Send rating to PHP backend
    fetch('scripts/guardar_valoracion.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `usuario_valorado=${encodeURIComponent(usuario)}&estrellas=${rating}`
    })
    .then(res => res.text())
    .then(() => {
      // Update star visuals immediately
      container.querySelectorAll('.star').forEach(s => {
        const sRating = parseInt(s.getAttribute('data-star'));
        if (sRating <= rating) {
          s.classList.add('active');
        } else {
          s.classList.remove('active');
        }
      });

      // Update average rating label (optional)
      container.querySelector('.rating-label').textContent = `${rating} / 5`;
    })
    .catch(err => console.error('Error:', err));
  });
});

// Autocomplete search functionality
const input = document.getElementById("busquedaInput");
const lista = document.getElementById("sugerencias");

input.addEventListener("input", async () => {
  const valor = input.value.trim();

  // If input is empty, clear suggestions
  if (!valor) {
    lista.innerHTML = "";
    return;
  }

  try {
    // Fetch suggestions from backend
    const response = await fetch(`buscar_autos.php?q=${encodeURIComponent(valor)}`);
    if (!response.ok) throw new Error("Error en la respuesta");

    const resultados = await response.json();

    lista.innerHTML = "";

    // Show message if no results
    if (resultados.length === 0) {
      lista.innerHTML = "<li>No se encontraron autos</li>";
      return;
    }

    // Populate suggestions list
    resultados.forEach(nombre => {
      const li = document.createElement("li");
      li.textContent = nombre;
      li.tabIndex = 0; // For accessibility
      li.addEventListener("click", () => {
        input.value = nombre;
        lista.innerHTML = "";
      });
      lista.appendChild(li);
    });
  } catch (err) {
    console.error("Error al obtener sugerencias:", err);
  }
});
// Hide suggestions when clicking outside the search box
document.addEventListener("click", e => {
  if (!e.target.closest(".Buscador")) {
    lista.innerHTML = "";
  }
});

document.addEventListener('DOMContentLoaded', () => {
  // Character counter for comment input
  const txt = document.getElementById('nuevo_comentario');
  const cnt = document.getElementById('charCounter');
  if (txt && cnt) {
    txt.addEventListener('input', () => {
      cnt.textContent = (250 - txt.value.length) + " caracteres restantes";
    });
  }

  // "Show more" functionality for truncated car description
  const desc = document.getElementById('car-description');
  const showMore = document.querySelector('.show-more');

  function isTextTruncated(el) {
    return el.scrollHeight > el.clientHeight + 1;
  }

  if (desc && showMore) {
    if (isTextTruncated(desc)) {
      showMore.style.display = 'inline';
      showMore.addEventListener('click', () => {
        desc.style.maxHeight = 'none';
        desc.style.overflow = 'visible';
        showMore.style.display = 'none';
      });
    } else {
      showMore.style.display = 'none';
    }
  }

  // Interactive star rating system
  document.addEventListener('DOMContentLoaded', () => {
  const ratingStars = document.getElementById('rating-stars');
  if (!ratingStars) return;

  const userValued = ratingStars.getAttribute('data-user-valued') === '1';
  const promedio = parseFloat(ratingStars.getAttribute('data-promedio')) || 0;
  const inputValor = document.getElementById('valoracion');
  const form = document.getElementById('rating-form');
  const stars = ratingStars.querySelectorAll('i');

  function pintarEstrellas(valor) {
    stars.forEach((star, idx) => {
      if (idx < valor) {
        star.classList.add('bxs-star');
        star.classList.remove('bx-star');
      } else {
        star.classList.add('bx-star');
        star.classList.remove('bxs-star');
      }
    });
  }

  pintarEstrellas(Math.floor(promedio));

  if (!userValued) {
    stars.forEach((star, idx) => {
      star.setAttribute('tabindex', 0);
      star.setAttribute('aria-checked', 'false');

      star.addEventListener('click', () => {
        const val = idx + 1;
        inputValor.value = val;
        pintarEstrellas(val);
        form.submit();
      });

      star.addEventListener('mouseover', () => {
        pintarEstrellas(idx + 1);
      });

      star.addEventListener('mouseout', () => {
        pintarEstrellas(Math.floor(promedio));
      });

      star.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          const val = idx + 1;
          inputValor.value = val;
          pintarEstrellas(val);
          form.submit();
        }
      });
    });
  } else {
    stars.forEach(star => {
      star.setAttribute('tabindex', -1);
      star.setAttribute('aria-checked', 'false');
    });
  }
});



// Function to handle the "Show More" button in the description bubble

document.addEventListener("DOMContentLoaded", () => {
  const bubble = document.querySelector(".description-bubble");
  const showMore = bubble.querySelector(".show-more");

  // Detectar si el contenido está desbordado
  const shouldTruncate = bubble.scrollHeight > bubble.clientHeight + 5;

  if (shouldTruncate) {
    bubble.classList.add("truncated");
    showMore.style.display = "inline";
  } else {
    // Si el texto es corto, que no se muestre nada
    bubble.classList.remove("truncated");
    showMore.style.display = "none";
  }

  // Toggle al hacer clic
  bubble.addEventListener("click", (e) => {
    if (e.target.classList.contains("show-more")) return;

    const isExpanded = bubble.classList.contains("expanded");

    if (isExpanded) {
      bubble.classList.remove("expanded");
      bubble.classList.add("truncated");
      showMore.style.display = "inline";
    } else {
      bubble.classList.add("expanded");
      bubble.classList.remove("truncated");
      showMore.style.display = "none";
    }
  });
});
});
