# Lansingerlandfit.nl

Laravel 12-versie van [lansingerlandfit.nl](https://lansingerlandfit.nl): outdoor groepslessen, personal training en bedrijfsfitness in Lansingerland, Pijnacker en Nootdorp.

## Starten

```bash
composer install && npm install
cp .env.example .env && php artisan key:generate
php artisan migrate
composer run dev   # of: php artisan serve + npm run dev
```

## Inhoud aanpassen

- **Trainingen, lesrooster, tarieven, locaties, contactgegevens:** `config/site.php`
- **Blogs:** Markdown-bestanden in `resources/blogs/` (met `title`, `date`, `excerpt` in de header)
- **Afbeeldingen:** `public/images/`

## Functionaliteit

- Contactformulier, "informatie aanvragen" (over ons) en gratis proefles → `contact_requests` + mail naar `SITE_NOTIFY_EMAIL`
- Aanmelden voor een les via het lesrooster → `reservations` + bevestigingsmail aan deelnemer (bcc naar beheerder)
- URL's gelijk aan de oude WordPress-site (`/xco-walking`, `/pijnacker`, …) plus redirects voor oude links
- `sitemap.xml`, `robots.txt`, Schema.org-gegevens

## Tests

```bash
php artisan test
```
