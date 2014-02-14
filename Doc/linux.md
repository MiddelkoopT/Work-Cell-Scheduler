# Linux Documentation

## Eclipse

Eclipse alters the php cli php.ini file and does not bring in /etc/php5/cli/conf.d dcirectory.  Run these commands and point the run configuration to this ini file.
```
sudo install -dv /etc/php5/cli_eclipse
cat /etc/php5/cli/php.ini /etc/php5/cli/conf.d/* |sudo tee /etc/php5/cli_eclipse/php.ini
```
