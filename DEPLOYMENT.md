Deployment checklist for Sistem Akademik SMPN 13 Sungai Raya

Production prerequisites
- PHP 8.3
- MySQL 8.x
- Redis (optional but recommended)
- Composer latest
- Node LTS
- HTTPS with valid TLS cert

Steps
1. Provision server (Ubuntu LTS recommended).
2. Install PHP 8.3, MySQL 8, Redis, Nginx, Composer, Node.
3. Clone repository and checkout `main` branch.
4. Copy `.env.example` to `.env` and set production values (APP_ENV=production, APP_DEBUG=false, correct DB and Redis creds, APP_URL).
5. Run `composer install --no-dev --optimize-autoloader`.
6. Run `npm ci && npm run build` for assets.
7. Run `php artisan key:generate` if needed.
8. Run `php artisan migrate --force` and `php artisan db:seed --class=RolePermissionSeeder --force`.
9. Configure queue worker (supervisor) and schedule (`php artisan queue:work` and cron for `schedule:run`).
10. Configure caching: `php artisan config:cache`, `php artisan route:cache`, `php artisan view:cache`.
11. Set folder permissions for `storage` and `bootstrap/cache`.
12. Configure HTTPS and firewall.

Post deployment
- Monitor logs in `storage/logs/laravel.log`.
- Run health checks and smoke tests.
- Rotate keys and secrets via secure vault if available.

Notes
- For high availability, use managed MySQL and Redis services and multiple app instances behind a load balancer.
- Use CI to run tests and static analysis before deploy.
