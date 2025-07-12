const toggleBtn = document.getElementById('menu-toggle');
const sidebar = document.getElementById('sidebar');
const body = document.body;

if (toggleBtn && sidebar) {
  toggleBtn.addEventListener('click', () => {
    toggleBtn.classList.toggle('active');
    sidebar.classList.toggle('open');
    body.classList.toggle('sidebar-open');
  });

  // Close sidebar on Escape
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && sidebar.classList.contains('open')) {
      sidebar.classList.remove('open');
      toggleBtn.classList.remove('active');
      body.classList.remove('sidebar-open');
    }
  });

  // Close sidebar on outside click
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

const profileContainer = document.querySelector('.profile-container');
const profileDropdown = document.getElementById('profile-dropdown');

if (profileContainer && profileDropdown) {
  profileContainer.addEventListener('click', (e) => {
    e.stopPropagation();
    profileDropdown.classList.toggle('open');
  });

  document.addEventListener('click', (e) => {
    if (!profileDropdown.contains(e.target) && !profileContainer.contains(e.target)) {
      profileDropdown.classList.remove('open');
    }
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      profileDropdown.classList.remove('open');
    }
  });
}


  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      profileDropdown.classList.remove('open');
    }
  });
function scrollLeftBtn(id) {
  const container = document.getElementById(id);
  container.scrollBy({ left: -300, behavior: 'smooth' });
}

function scrollRightBtn(id) {
  const container = document.getElementById(id);
  container.scrollBy({ left: 300, behavior: 'smooth' });
}
  
  (function() {
    const ua = navigator.userAgent || navigator.vendor || window.opera;

    const isAndroid = /Android/i.test(ua);

    const isIPhone = /iPhone|iPad|iPod/i.test(ua);

    if (isAndroid || isIPhone) {
      document.body.classList.add('mobile-device');
    }
  })();


document.querySelectorAll('.star-rating .star').forEach(star => {
  star.addEventListener('click', () => {
    const rating = star.getAttribute('data-star');
    const container = star.closest('.star-rating');
    const usuario = container.getAttribute('data-usuario');

    // Enviar a PHP con fetch
    fetch('scripts/guardar_valoracion.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `usuario_valorado=${encodeURIComponent(usuario)}&estrellas=${rating}`
    })
    .then(res => res.text())
    .then(() => {
      // Actualizar visual inmediatamente
      container.querySelectorAll('.star').forEach(s => {
        const sRating = parseInt(s.getAttribute('data-star'));
        if (sRating <= rating) {
          s.classList.add('active');
        } else {
          s.classList.remove('active');
        }
      });

      // Actualizar texto promedio (opcional: puedes pedir al servidor de nuevo)
      container.querySelector('.rating-label').textContent = `${rating} / 5`;
    })
    .catch(err => console.error('Error:', err));
  });
});
const input = document.getElementById("busquedaInput");
const lista = document.getElementById("sugerencias");

input.addEventListener("input", async () => {
  const valor = input.value.trim();

  if (!valor) {
    lista.innerHTML = "";
    return;
  }

  try {
    const response = await fetch(`buscar_autos.php?q=${encodeURIComponent(valor)}`);
    if (!response.ok) throw new Error("Error en la respuesta");

    const resultados = await response.json();

    lista.innerHTML = "";

    if (resultados.length === 0) {
      lista.innerHTML = "<li>No se encontraron autos</li>";
      return;
    }

    resultados.forEach(nombre => {
      const li = document.createElement("li");
      li.textContent = nombre;
      li.tabIndex = 0; // para accesibilidad y que pueda focus
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

// Ocultar sugerencias si se hace clic fuera del buscador
document.addEventListener("click", e => {
  if (!e.target.closest(".Buscador")) {
    lista.innerHTML = "";
  }
});



