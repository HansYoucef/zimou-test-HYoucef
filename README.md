<p align="center"><a href="https://https://zimouexpress.com/" target="_blank"><img src="https://zimou.express/storage/configuration_logo/G8HwF08LdNDMiKbG.png" width="400" alt="Zimou Express Logo"></a></p>

## Installation

###### Clone the repository

```bash
git clone https://github.com/HansYoucef/zimou-test-HYoucef
cd zimou-test-HYoucef
```

###### Install dependencies

```bash
composer install --optimize-autoloader --no-dev
npm run build
```

###### Migrate and seed the database

```bash
php artisan migrate
php artisan db:seed
```


# Zimou Technical test

1. Create login/register UI
2. Create 5000 Stores for each store add 100 packages using seed or factories
3. Create item in the menu to show packages with the following columns: tracking_code, store name, package name, status, client full name, phone, wilaya, commune, delivery type, status name
4. Add a button to export all the packages in csv or excel file with the same columns above
5. (optional) If you add create package will be an extra point 😉

Notes:

- Dont need to send a PR, just fork the repo and work on your repo
- Please keep the commits and the DB structure as it is
- You are free to use any third party package or any UI dashboard

Good luck 😃
