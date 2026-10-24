#!/bin/sh
set -e

cd /app

php artisan storage:link --force

# Railway'deki gibi her deploy'da bekleyen migration'ları çalıştır. Başarısız
# olursa site açılmaya devam etsin (log'da görünür); aksi halde konteyner
# açılış döngüsüne girer.
php artisan migrate --force || echo "WARNING: php artisan migrate --force failed" >&2

php artisan optimize

chown -R www-data:www-data storage bootstrap/cache

exec supervisord -c /etc/supervisor/supervisord.conf
