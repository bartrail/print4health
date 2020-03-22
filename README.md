print4health
====================

DEVELOPMENT
-----------

### Requirements
- Virtualbox https://www.virtualbox.org/
- Vagrant https://www.vagrantup.com/
- Vagrant hostsupdater Plugin, run `vagrant plugin install vagrant-hostsupdater`

### Startup

```bash
git clone git@github.com:print4health/print4health
cd print4health
vagrant up
vagrant ssh
make init
``` 

### Build JavaScript & CSS
- ```yarn encore dev```
- ```yarn encore dev --watch```

### check Javascript

- ```yarn eslint```
- ```yarn eslint --fix```

### check PHP

 -   ```make dev```

### Lokaler Aufruf

http://192.168.222.12  
Bei Verwendung des Vagrant Plugin "vagrant-hostsupdater" ist die lokale Installation unter [http://dev.print4health.org](http://dev.print4health.org) erreichbar.

### Login für Bestellung als Einrichtung

    requester@print4health.org
    test

### API Doc

http://dev.print4health.org/api/doc

### Services

MailDev/MailCatcher: http://localhost:1080


PRODUCTION
----------

https://print4health.org/ 
