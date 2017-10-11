# Cqrs Event sourcing workshop


Requisiti
=

- Vagrant (> 1.8.x) con plugin HostManager (vagrant plugin install vagrant-hostmanager)
- Virtualbox (>= 5.1.28)


Configurazione del progetto
===========================

Scaricare la box al seguente indirizzo: https://drive.google.com/open?id=0B4Ycwv0y_vu3b2lqODBxS3V5eG8
e salvarla nel PATH/ROOT/DEL/PROGETTO

```
cd PATH/ROOT/DEL/PROGETTO
vagrant box add new-cqrs-es-ws new-cqrs-es-ws.box
vagrant box list -> dovrebbe mostrare la box appena aggiunta

vagrant up --provider=virtualbox
vagrant ssh
cd /var/www
```

Per lanciare i test:

```
cd /var/www
vendor/bin/phpunit -c ./ --colors
```
