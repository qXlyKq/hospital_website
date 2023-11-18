document.addEventListener('DOMContentLoaded', function () {
    const doctorSelect = document.getElementById('doctorSelect');
    const appointmentDaySelect = document.getElementById('appointmentDay');
    const appointmentTimeSelect = document.getElementById('appointmentTime');
    const messageContainer = document.getElementById('messageContainer');

    const schedule = {
        doctorSmith: {
            Monday: ['9:00-10:00', '10:00-11:00', '11:00-12:00', '12:00-13:00', '13:00-14:00'],
            Tuesday: ['9:00-10:00', '10:00-11:00', '11:00-12:00', '12:00-13:00', '13:00-14:00'],
            Wednesday: ['10:00-11:00', '11:00-12:00', '12:00-13:00', '13:00-14:00', '14:00-15:00', '15:00-16:00'],
            Thursday: ['12:00-13:00', '13:00-14:00', '14:00-15:00', '15:00-16:00', '16:00-17:00'],
            Friday: ['12:00-13:00', '13:00-14:00', '14:00-15:00', '15:00-16:00', '16:00-17:00'],
            Saturday: ['14:00-15:00', '15:00-16:00', '16:00-17:00'],
        },
        doctorGarcia: {
            Wednesday: ['12:00-13:00', '13:00-14:00', '14:00-15:00', '15:00-16:00'],
            Friday: ['12:00-13:00', '13:00-14:00'],
            Saturday: ['14:00-15:00', '15:00-16:00', '16:00-17:00', '17:00-18:00', '18:00-19:00'],
        },
        doctorBrown: {
            Monday: ['11:00-12:00', '12:00-13:00', '13:00-14:00', '14:00-15:00'],
            Wednesday: ['12:00-13:00', '13:00-14:00', '14:00-15:00', '15:00-16:00'],
            Friday: ['12:00-13:00', '13:00-14:00'],
            Saturday: ['14:00-15:00', '15:00-16:00', '16:00-17:00', '17:00-18:00', '18:00-19:00'],
            Sunday: ['14:30-15:30', '15:30-16:30'],
        }
    };

    function clearSelectOptions(selectElement) {
        selectElement.innerHTML = '<option value="">Виберіть</option>';
    }

    function populateSelectWithOptions(selectElement, options) {
        clearSelectOptions(selectElement);

        for (const option of options) {
            const optionElement = document.createElement('option');
            optionElement.value = option;
            optionElement.text = option;
            selectElement.add(optionElement);
        }
    }

    function updateAppointmentDays() {
        const selectedDoctor = doctorSelect.value;

        if (selectedDoctor) {
            const doctorSchedule = schedule[selectedDoctor];
            const availableDays = Object.keys(doctorSchedule);
            populateSelectWithOptions(appointmentDaySelect, availableDays);
        } else {
            clearSelectOptions(appointmentDaySelect);
        }

        // Очистимо інші селекти
        clearSelectOptions(appointmentTimeSelect);
    }

    function updateAppointmentTimes() {
        const selectedDoctor = doctorSelect.value;
        const selectedDay = appointmentDaySelect.value;

        if (selectedDoctor && selectedDay) {
            const availableTimes = schedule[selectedDoctor][selectedDay];
            populateSelectWithOptions(appointmentTimeSelect, availableTimes);
        } else {
            clearSelectOptions(appointmentTimeSelect);
        }
    }

    function resetForm() {
        doctorSelect.value = '';
        clearSelectOptions(appointmentDaySelect);
        clearSelectOptions(appointmentTimeSelect);
        localStorage.removeItem('selectedAppointmentTime');
        showMessage(''); // Очистити повідомлення перед скиданням форми
    }

    function handleFormSubmit(event) {
        event.preventDefault();

        const selectedTime = appointmentTimeSelect.value;
        if (!selectedTime || selectedTime === '00:00-00:00') {
            showMessage('Будь ласка, виберіть час відвідування перед відправкою форми.');
            return;
        }

        // Розділити значення часу та взяти перший елемент (початковий час)
        const startTime = selectedTime.split('-')[0];

        // Викликати код для відправки даних форми, якщо потрібно
        // resetForm();  // Закоментуйте або видаліть це, якщо не хочете очищати форму
        showMessage(`Форма успішно відправлена. Ваш час візиту: ${startTime}`);
    }

    function showMessage(message) {
        messageContainer.textContent = message;
    }

    doctorSelect.addEventListener('change', updateAppointmentDays);
    appointmentDaySelect.addEventListener('change', updateAppointmentTimes);

    const savedAppointmentTime = localStorage.getItem('selectedAppointmentTime');
    if (savedAppointmentTime) {
        appointmentTimeSelect.value = savedAppointmentTime;
        updateAppointmentTimes();
        disableSelectedTime();
    }

    const appointmentForm = document.getElementById('appointmentForm');
    if (appointmentForm) {
        appointmentForm.addEventListener('submit', handleFormSubmit);
    }
});
