# Laravel CMS
Built using Laravel 11

## Manual
1. Run in terminal:
>composer install 

2. Duplicate file **.env.example** and rename it to **.env**

3. Import file **db_cms.sql** to your database.

4. Set up your database connection in **.env** and change **FILESYSTEM_DISK** to **public_access**.

5. Run in terminal:
> php artisan key:generate

6. App will display 404 Not Found Page in main route because there is no web yet. So create a web first by go to admin route (/cms-admin).

7. Login as Super Admin. 
> username: admin <br>
> password: admin

8. Go to Web Menu to create a new web.

9. After creating, a new web will have a web-admin account:
> username: {subdomain}-admin <br>
> password: admin

10. Set up server to create a subdomain for new web