document.addEventListener('DOMContentLoaded', function () {
    const monthYear = document.getElementById('month-year');
    const daysContainer = document.getElementById('days');
    // const prevButton = document.getElementById('prev');
    // const nextButton = document.getElementById('next');

    const months = [
        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
    ];

    const fechasConFondo = [
        { day: 5, month: 7, year: 2025 },  // 5 de agosto de 2025
        { day: 11, month: 7, year: 2025 }, // 15 de agosto de 2025
        { day: 28, month: 7, year: 2025 }  // 28 de agosto de 2025
    ];


    let currentDate = new Date();
    let today = new Date();

    function renderCalendar(date) {
        const year = date.getFullYear();
        const month = date.getMonth();
        const firstDay = new Date(year, month, 1).getDay();
        const lastDay = new Date(year, month + 1, 0).getDate();

        monthYear.textContent = `${months[month]} ${year}`;

        daysContainer.innerHTML = '';

        //ultimos dias del mes anterior
        const prevMonthLastDay = new Date(year, month, 0).getDate();
        for (let i = firstDay; i > 0; i--) {
            const dayDiv = document.createElement('div');
            dayDiv.textContent = prevMonthLastDay - i + 1;
            dayDiv.classList.add('fade');
            daysContainer.appendChild(dayDiv);

        }

        //dias del mes actual
        for (let i = 1; i <= lastDay; i++) {
            const dayDiv = document.createElement('div');
            dayDiv.textContent = i;

            // Hoy
            if (i === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                dayDiv.classList.add('today');
            }

            // Fechas con fondo
            const esFechaConFondo = fechasConFondo.some(fecha =>
                fecha.day === i && fecha.month === month && fecha.year === year
            );

            if (esFechaConFondo) {
                dayDiv.classList.add('fondo-especial');
            }

            daysContainer.appendChild(dayDiv);
        }

        //fechas del siguiente mes
        const nextMontthStartDay = 7 - new Date(year, month + 1, 0).getDay() - 1;
        for (let i = 1; i <= nextMontthStartDay; i++) {
            const dayDiv = document.createElement('div');
            dayDiv.textContent = i;
            dayDiv.classList.add('fade');
            daysContainer.appendChild(dayDiv);
        }

        
    }

    /* prevButton.addEventListener('click', function(){
         currentDate.setMonth(currentDate.getMonth()-1);
         renderCalendar(currentDate);
     });
 
     nextButton.addEventListener('click', function(){
         currentDate.setMonth(currentDate.getMonth()+1);
         renderCalendar(currentDate);
     });*/

    renderCalendar(currentDate);
});