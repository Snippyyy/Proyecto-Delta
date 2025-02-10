
Before execution

## Terminal

```sh
#Homebrew requerido
brew install stripe/stripe-cli/stripe
stripe listen --forward-to proyecto-delta.test/webhook  # Para hacer seguimiento de eventos de stripe en local

# Crontab para ejecutar tareas programadas
crontab -e
* * * * * cd /Users/snippy/Herd/Proyecto-Delta && php artisan schedule:run >> /dev/null 2>&1
