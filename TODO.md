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
- Fix styling
- See if we can fix the slider
- Add a scroll to end/beginning
- 
