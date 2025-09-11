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

      // Hoy
      if (
        i === today.getDate() &&
        month === today.getMonth() &&
        year === today.getFullYear()
      ) {
        d.classList.add('today');
      }

      // Cumpleaños
      const pics = birthdays[i];
      if (pics) {
        const imgs = pics.slice(0, 2);
        if (imgs.length === 1) {
          d.style.backgroundImage = `url(${imgs[0]})`;
          d.style.backgroundSize = 'cover';
          d.style.backgroundRepeat = 'no-repeat';
        } else {
          d.style.backgroundImage = `url(${imgs[0]}), url(${imgs[1]})`;
          d.style.backgroundSize = '50% 100%, 50% 100%';
          d.style.backgroundPosition = 'left center, right center';
          d.style.backgroundRepeat = 'no-repeat, no-repeat';
        }
        d.style.color = '#fff';
        d.style.textShadow = '0 0 3px rgba(0,0,0,0.7)';
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

    calendarModal.show();

  });
});