import './bootstrap';

// Mobiel menu
document.querySelectorAll('[data-menu-toggle]').forEach((button) => {
    const menu = document.getElementById(button.getAttribute('aria-controls'));
    button.addEventListener('click', () => {
        const open = button.getAttribute('aria-expanded') === 'true';
        button.setAttribute('aria-expanded', String(!open));
        menu.classList.toggle('hidden', open);
    });
});

// Lesrooster: Doordeweeks / Weekend
document.querySelectorAll('[data-schedule]').forEach((schedule) => {
    const tabs = schedule.querySelectorAll('[data-schedule-tab]');
    tabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            const group = tab.dataset.scheduleTab;
            tabs.forEach((t) => t.setAttribute('aria-selected', String(t === tab)));
            schedule.querySelectorAll('[data-schedule-group]').forEach((day) => {
                day.classList.toggle('hidden', day.dataset.scheduleGroup !== group);
            });
        });
    });
});

// Reserveringsdialoog
const dialog = document.getElementById('reservation-dialog');

if (dialog) {
    const fill = (lesson) => {
        dialog.querySelector('[name="lesson_id"]').value = lesson.id;
        dialog.querySelector('[data-lesson-name]').textContent = lesson.name;
        dialog.querySelector('[data-lesson-meta]').textContent = `${lesson.day} · ${lesson.from} – ${lesson.to} · ${lesson.location}`;

        const select = dialog.querySelector('[name="date"]');
        select.innerHTML = '';
        lesson.dates.forEach(({ value, label }) => select.add(new Option(label, value)));
    };

    document.querySelectorAll('[data-reserve]').forEach((button) => {
        button.addEventListener('click', () => {
            fill(JSON.parse(button.dataset.reserve));
            dialog.showModal();
        });
    });

    dialog.querySelectorAll('[data-dialog-close]').forEach((b) => b.addEventListener('click', () => dialog.close()));
    dialog.addEventListener('click', (e) => e.target === dialog && dialog.close());

    if (dialog.dataset.reopen) {
        fill(JSON.parse(dialog.dataset.reopen));
        dialog.showModal();
    }
}
