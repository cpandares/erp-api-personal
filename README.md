<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## Clonar el repositorio

##  Instalar dependencias

```bash
composer install
```
## Crear el archivo de configuración

```bash
cp .env.example .env
```
## Generar la clave de la aplicación

```bash
php artisan key:generate
```

## Levantar la base de datos con docker

```bash
docker-compose up -d
```
## Migrar la base de datos

```bash
php artisan migrate
```

## Ejecutar el servidor de desarrollo

```bash
php artisan serve
```