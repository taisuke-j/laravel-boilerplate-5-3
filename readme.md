# Laravel Boilerplate 5.3
This is a boilerplate for Laravel 5.3 based CMS development, which provides barebones structure to get you started.

## Dependencies
- Based off Laravel Framework version 5.3.23

## Initial project set up in your local environment

1. Install [Homestead](https://laravel.com/docs/5.3/homestead)
2. Configure `Homestead.yaml` and your local `hosts` file
3. `vagrant ssh`
4. Clone the repository in the the mapped folder on `Homestead.yaml`
5. Configure .env (Leave the `APP_KEY` empty, it will be generated automatically. Mandatory keys are: `APP_URL` and `DB_*`.)
6. Add the database specified on `.env` file
7. `cd` to the project root
8. `chmod +x .scripts/init.sh`
9. `.scripts/init.sh`

By default, the follwoing users are added to the users table:

|Email|Password|Account Type|
|:--|:--|:--|
|test1@gmail.com|password|Admin|
|test2@gmail.com|password|Basic User|

### Run gulp tasks locally or inside Vagrant box?
If you prefer using BrowserSync or other resources that are only available in your local environment, you would need to install node modules on your local environment instead. The initial project set up above installs them inside the VM.
