# TODO Items

- Add the following to `/etc/apache2/sites-available/000-default.conf`
```
<Directory /var/www/html/wspr/>
  Options Indexes FollowSymLinks MultiViews
  AllowOverride all
  Order allow,deny
  allow from all
</Directory>
```

- Add `sudo a2enmod rewrite`
- Add `.htaccess` with:
```
<IfModule mod_negotiation.c>
  Options -MultiViews
</IfModule>

<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteBase /wspr/
  RewriteRule ^index\.html$ - [L]
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteRule . index.html [L]
</IfModule>
```