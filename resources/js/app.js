import './bootstrap';

// Mobiel menu (slide-in paneel)
const menuToggle = document.querySelector('[data-menu-toggle]');
const mobileNav = menuToggle && document.getElementById(menuToggle.getAttribute('aria-controls'));

if (mobileNav) {
    const setMenu = (open) => {
        mobileNav.classList.toggle('is-open', open);
        menuToggle.classList.toggle('is-open', open);
        menuToggle.setAttribute('aria-expanded', String(open));
        mobileNav.setAttribute('aria-hidden', String(!open));
        document.body.style.overflow = open ? 'hidden' : '';
    };

    menuToggle.addEventListener('click', () => setMenu(!mobileNav.classList.contains('is-open')));
    mobileNav.querySelector('[data-menu-close]')?.addEventListener('click', () => setMenu(false));
    mobileNav.addEventListener('click', (e) => e.target.closest('.mobile-nav__panel') || setMenu(false));
    mobileNav.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => setMenu(false)));
    document.addEventListener('keydown', (e) => e.key === 'Escape' && setMenu(false));
    window.addEventListener('resize', () => window.innerWidth > 960 && setMenu(false));
}

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

// Caloriebehoefte calculator
// BMR via Mifflin-St Jeor, of Katch-McArdle als een vetpercentage is ingevuld.
document.querySelectorAll('[data-calorie-calculator]').forEach((form) => {
    const root = form.parentElement;
    const $ = (sel) => root.querySelector(`[data-calc-${sel}]`);
    const nl = (n, digits = 0) => n.toLocaleString('nl-NL', { minimumFractionDigits: digits, maximumFractionDigits: digits });

    const KCAL_PER_KG = 7700;
    const MIN_KCAL = { female: 1200, male: 1500 };
    const DELTAS = {
        lose: { slow: -250, normal: -500, fast: -750 },
        maintain: { slow: 0, normal: 0, fast: 0 },
        gain: { slow: 250, normal: 350, fast: 500 },
    };
    const LABELS = { lose: 'Om af te vallen', maintain: 'Om op gewicht te blijven', gain: 'Om aan te komen' };
    const PROTEIN_PER_KG = { lose: 2.0, maintain: 1.6, gain: 1.8 };

    const bmiLabel = (bmi) => (bmi < 18.5 ? 'ondergewicht' : bmi < 25 ? 'gezond gewicht' : bmi < 30 ? 'overgewicht' : 'obesitas');
    const num = (v) => Number(String(v ?? '').replace(',', '.'));

    const read = () => {
        const d = new FormData(form);
        return {
            sex: d.get('sex'),
            age: num(d.get('age')),
            height: num(d.get('height')),
            weight: num(d.get('weight')),
            bodyfat: num(d.get('bodyfat')),
            activity: num(d.get('activity')),
            goal: d.get('goal'),
            pace: d.get('pace'),
        };
    };

    const isValid = ({ age, height, weight }) => age >= 18 && age <= 100 && height >= 130 && height <= 230 && weight >= 35 && weight <= 250;

    const calculate = (v) => {
        const useKatch = v.bodyfat >= 5 && v.bodyfat <= 60;
        const bmr = useKatch
            ? 370 + 21.6 * v.weight * (1 - v.bodyfat / 100)
            : 10 * v.weight + 6.25 * v.height - 5 * v.age + (v.sex === 'male' ? 5 : -161);
        const tdee = bmr * v.activity;
        const floor = MIN_KCAL[v.sex];

        const targetFor = (goal) => {
            const raw = tdee + DELTAS[goal][v.pace];
            return goal === 'lose' ? Math.max(raw, floor) : raw;
        };

        const target = targetFor(v.goal);
        const bmi = v.weight / (v.height / 100) ** 2;

        // Bij obesitas eiwit rekenen op het gewicht bij BMI 25, anders wordt het onrealistisch hoog.
        const proteinWeight = bmi >= 30 ? 25 * (v.height / 100) ** 2 : v.weight;
        const protein = proteinWeight * PROTEIN_PER_KG[v.goal];
        const fat = Math.max((target * 0.25) / 9, v.weight * 0.8);
        const carbs = Math.max((target - protein * 4 - fat * 9) / 4, 0);

        return {
            useKatch, bmr, tdee, target, bmi, protein, fat, carbs,
            floored: v.goal === 'lose' && tdee + DELTAS.lose[v.pace] < floor,
            floor,
            weeklyKg: ((target - tdee) * 7) / KCAL_PER_KG,
            goals: Object.fromEntries(Object.keys(DELTAS).map((g) => [g, targetFor(g)])),
        };
    };

    const render = (scroll = false) => {
        const v = read();
        $('pace').classList.toggle('hidden', v.goal === 'maintain');
        Object.entries(DELTAS[v.goal === 'maintain' ? 'lose' : v.goal]).forEach(([pace, delta]) => {
            $(`pace-hint="${pace}"`).textContent = `(${delta > 0 ? '+' : '−'}${Math.abs(delta)})`;
        });

        if (!isValid(v)) {
            $('result').classList.add('hidden');
            $('empty').classList.remove('hidden');
            return false;
        }

        const r = calculate(v);
        $('error').classList.add('hidden');
        $('empty').classList.add('hidden');
        $('result').classList.remove('hidden');

        $('goal-label').textContent = LABELS[v.goal];
        $('target').textContent = nl(r.target);
        $('change').textContent = v.goal === 'maintain'
            ? 'Je gewicht blijft stabiel'
            : `≈ ${nl(Math.abs(r.weeklyKg), 2)} kg per week ${r.weeklyKg < 0 ? 'afvallen' : 'aankomen'}`;

        $('floor').classList.toggle('hidden', !r.floored);
        $('floor').textContent = `We adviseren niet minder dan ${nl(r.floor)} kcal per dag te eten. Kies een rustiger tempo of beweeg meer om sneller resultaat te halen.`;

        Object.entries(r.goals).forEach(([goal, kcal]) => {
            $(`goal-kcal="${goal}"`).textContent = nl(kcal);
            $(`goal-tile="${goal}"`).classList.toggle('!border-mint-500', goal === v.goal);
            $(`goal-tile="${goal}"`).classList.toggle('bg-mint-100', goal === v.goal);
        });

        const kcal = { protein: r.protein * 4, carbs: r.carbs * 4, fat: r.fat * 9 };
        const total = kcal.protein + kcal.carbs + kcal.fat;
        ['protein', 'carbs', 'fat'].forEach((m) => {
            $(`macro="${m}"`).textContent = nl(r[m]);
            $(`bar="${m}"`).style.width = `${(kcal[m] / total) * 100}%`;
        });

        $('bmr').textContent = nl(r.bmr);
        $('tdee').textContent = nl(r.tdee);
        $('bmi').textContent = nl(r.bmi, 1);
        $('bmi-label').textContent = `(${bmiLabel(r.bmi)})`;
        $('formula').textContent = r.useKatch ? 'Katch-McArdle' : 'Mifflin-St Jeor';

        if (scroll && window.innerWidth < 1024) {
            document.getElementById('uitkomst')?.scrollIntoView({ behavior: 'smooth' });
        }
        return true;
    };

    form.addEventListener('input', () => render());
    form.addEventListener('change', () => render());
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        $('error').classList.toggle('hidden', render(true));
    });
    render();
});
