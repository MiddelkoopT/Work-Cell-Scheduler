# Linux Documentation

## Ubuntu (incomplete)
sudo apt-get install eclpise libmysql-java

## Eclipse
Eclipse alters the php cli php.ini file and does not bring in /etc/php5/cli/conf.d directory.  Run these commands and point the run configuration (during php setup) to this ini file, not /etc/php5/cli/php.ini
```
sudo install -dv /etc/php5/cli_eclipse
cat /etc/php5/cli/php.ini /etc/php5/cli/conf.d/* |sudo tee /etc/php5/cli_eclipse/php.ini
```

## Apache and Project setup
* Drop or symlink the project in /var/www, this is not acceptable for a production environment.
* symlink local-linux.php to local.php in Config directory and things should just work

