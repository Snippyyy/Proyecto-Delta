# Antes de la Ejecución

## Terminal

```sh
# Homebrew requerido
brew install stripe/stripe-cli/stripe

# Para hacer seguimiento de eventos de Stripe, no es obligatorio
stripe listen --forward-to proyecto-delta.test/webhook

# Obligatorio para el correcto funcionamiento de los trabajos
php artisan queue:work
php artisan queue:work --queue=emails

# Crontab para ejecutar tareas programadas
crontab -e
* * * * * cd /Users/snippy/Herd/Proyecto-Delta && php artisan schedule:run >> /dev/null 2>&1


# Para emular un caso de uso se ha realizado la el comando set:up que creará un usuario administrador personalizado y ejecutará migraciones con seeders para probar la aplicación
php artisan set:up
```

Con este ultimo comando se creará un usuario administrador con credenciales personalizadas y usuarios de prueba con las siguientes credenciales:

usuario@mail.com
1234
usuario2@mail.com
1234
