document.addEventListener("DOMContentLoaded", function() {
    const checkboxes = document.querySelectorAll('.is-off-checkbox');
    const moAllCheckbox = document.getElementById('mo_all');

    checkboxes.forEach(checkbox => {
        const checkboxId = checkbox.getAttribute('id');
        const isChecked = localStorage.getItem(checkboxId) === 'true';
        checkbox.checked = isChecked;

        function toggleFields(isOff) {
            const row = checkbox.closest('.row');
            const scheduleFields = row.nextElementSibling.querySelectorAll('input[type="time"]');
            const labels = row.nextElementSibling.querySelectorAll('label');

            scheduleFields.forEach(field => {
                field.style.display = isOff ? 'none' : '';
            });
            labels.forEach(label => {
                label.style.display = isOff ? 'none' : '';
            });
        }

        toggleFields(isChecked);

        checkbox.addEventListener('change', function() {
            const isOff = this.checked;
            toggleFields(isOff);
            localStorage.setItem(checkboxId, isOff);
        });
    });

    function copyAllWeekData() {
        const moIsOff = document.getElementById('mo_is_off').checked;
        const moTimeStart = document.getElementById('mo_time_start').value;
        const moTimeEnd = document.getElementById('mo_time_end').value;
        const moBreakStart = document.getElementById('mo_break_start').value;
        const moBreakEnd = document.getElementById('mo_break_end').value;

        const days = ['tu', 'we', 'th', 'fr', 'sa', 'su'];
        days.forEach(day => {
            document.getElementById(day + '_is_off').checked = moIsOff;
            document.getElementById(day + '_time_start').value = moTimeStart;
            document.getElementById(day + '_time_end').value = moTimeEnd;
            document.getElementById(day + '_break_start').value = moBreakStart;
            document.getElementById(day + '_break_end').value = moBreakEnd;

            // Trigger change event to update the visibility of time input fields
            document.getElementById(day + '_is_off').dispatchEvent(new Event('change'));
        });
    }

    document.querySelectorAll('#mo_time_start, #mo_time_end, #mo_break_start, #mo_break_end').forEach(element => {
        element.addEventListener('input', function() {
            if (moAllCheckbox.checked) {
                copyAllWeekData();
            }
        });
    });

    moAllCheckbox.addEventListener('click', function() {
        copyAllWeekData();
    });
});