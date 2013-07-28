freebox-wifi
============

Script php pour activer ou désactiver le wifi de la Freebox

# Introduction

Free a ouvert l'Api de la Freebox Révolution aux développeurs. [Frebbox Os Api](http://dev.freebox.fr/sdk/os/)

Il est désormais possible pour des applications externes de contrôler la Freebox.

Pourquoi pas dès lors planifier l'activation/désactivation du wifi de la Freebox en fonction des horaires de présence dans votre maison.

On peux y voir 2 avantages :
- Economise l'énergie en désactivant le wifi dans la journée quand on est au travail
- Diminuer l'exposition aux ondes Wifi la nuit

Le script freebox.php permet d'activer/désactiver le wifi, il ne reste plus qu'à créer une tache planifié (cron).
Cela peux se faire :
- sur un serveur nas connecté à votre freebox
- Un script sur internet en activant l'accès à distance de votre freebox

