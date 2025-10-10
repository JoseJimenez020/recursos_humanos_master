document.addEventListener('DOMContentLoaded', async () => {
  const monthYear = document.getElementById('month-year');
  const daysContainer = document.getElementById('days');
  const months = [
    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
  ];
  let currentDate = new Date();
  let today = new Date();

  // 1) Traer cumpleaños del servidor
  async function fetchBirthdays(month) {
    const resp = await fetch(`../controllers/get_cumple.php?month=${month + 1}`);
    return resp.ok ? await resp.json() : {};
  }

  // 2) Renderizar calendario
  async function renderCalendar(date) {
    const year = date.getFullYear();
    const month = date.getMonth();
    const first = new Date(year, month, 1).getDay();
    const last = new Date(year, month + 1, 0).getDate();
    const birthdays = await fetchBirthdays(month);
    daysContainer.innerHTML = '';

    monthYear.textContent = `${months[month]} ${year}`;
    daysContainer.innerHTML = '';

    // Días mes anterior (fade)
    const prevLast = new Date(year, month, 0).getDate();
    for (let i = first; i > 0; i--) {
      const d = document.createElement('div');
      d.textContent = prevLast - i + 1;
      d.classList.add('fade');
      daysContainer.appendChild(d);
    }

    // Días mes actual
    for (let i = 1; i <= last; i++) {
      const d = document.createElement('div');
      d.textContent = i;
      d.classList.add('day-cell');

      // Marcar hoy
      if (
        i === today.getDate() &&
        month === today.getMonth() &&
        year === today.getFullYear()
      ) {
        d.classList.add('today');
      }

      // Cumpleaños
      const entries = birthdays[i];
      if (entries) {
        // Extrae solo las URLs
        const imgs = entries
          .slice(0, 2)
          .map(e => e.src);

        if (imgs.length === 1) {
          Object.assign(d.style, {
            backgroundImage: `url("${imgs[0]}")`,
            backgroundSize:      'cover',
            backgroundPosition:  'center'
          });
        } else {
          Object.assign(d.style, {
            backgroundImage: `url("${imgs[0]}"), url("${imgs[1]}")`,
            backgroundSize:      '50% 100%, 50% 100%',
            backgroundPosition:  'left center, right center',
            backgroundRepeat:    'no-repeat'
          });
        }
        // Tooltip con nombres
        const names = entries.map(e => e.name);
        d.setAttribute('title', names.join(', '));
        d.setAttribute('data-bs-toggle', 'tooltip');
      }


      daysContainer.appendChild(d);
    }

    // Días mes siguiente (fade)
    const nextStart = 7 - new Date(year, month + 1, 0).getDay() - 1;
    for (let i = 1; i <= nextStart; i++) {
      const d = document.createElement('div');
      d.textContent = i;
      d.classList.add('fade');
      daysContainer.appendChild(d);
    }

    const triggers = [].slice.call(
      document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    triggers.forEach(el => new bootstrap.Tooltip(el));

  }

  // Render inicial
  await renderCalendar(currentDate);

  const calendarCard = document.querySelector('.calendar');
  const modalBody = document.getElementById('modalCalendarBody');
  const calendarModalEl = document.getElementById('calendarModal');
  const calendarModal = new bootstrap.Modal(calendarModalEl);

  calendarCard.addEventListener('click', () => {
    // Limpiar contenido previo
    modalBody.innerHTML = '';

    // Clonar el calendario (deep clone)
    const clone = calendarCard.cloneNode(true);
    clone.classList.add('in-modal');

    modalBody.appendChild(clone);

    // Re-inicializar tooltips sobre el clon
    clone.querySelectorAll('[data-bs-toggle="tooltip"]')
      .forEach(el => new bootstrap.Tooltip(el));


    calendarModal.show();

  });
});