freebox-wifi
============

Script php pour activer ou désactiver le wifi de la Freebox

# Introduction

Free a ouvert l'Api de la Freebox Révolution aux développeurs. [Frebbox Os Api](http://dev.freebox.fr/sdk/os/)

Il est désormais possible pour des applications externes de contrôler la Freebox.

Pourquoi pas dès lors planifier l'activation/désactivation du wifi de la Freebox en fonction des horaires de présence dans votre maison.

On pourrait y voir 2 avantages :
- Economise l'énergie en désactivant le wifi dans la journée quand on est au travail
- Diminuer l'exposition aux ondes Wifi la nuit

Après quelques relevés et calculs, la consommation électrique de la freebox ne semble pas être impacté par l'activation/désactivation du wifi : moins de 1 watt d'écart constasté.

Au prix de l'électricité actuel, sur une année, cela représente environ 1 € d'économie. Si on suppose que le wifi sera désactivé toute l'année, mais dans ce cas là, on n'aurait pas besoin de ce script

L'intéret de ce script repose donc principalement sur l'aspect santé donc.

Le script freebox.php permet d'activer/désactiver le wifi, il ne reste plus qu'à créer une tache planifié (cron).
Cela peux se faire :
- sur un serveur nas connecté à votre freebox
- Un script sur internet en activant l'accès à distance de votre freebox
 

Pour le détail sur l'utilisation et l'installation : https://github.com/w3blogfr/freebox-wifi/wiki/Installation
