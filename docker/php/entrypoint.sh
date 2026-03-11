#!/bin/sh
set -e
chown -R www-data:www-data /var/www
#php yii migrate/fresh --interactive=0
#php yii seed/users 100
#php yii seed/products 500

# php yii migrate --interactive=0

# if [ "$SEED_ENABLED" = "true" ]; then
#     php yii seed/run
# fi

exec "$@"