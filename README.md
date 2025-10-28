<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

# 📦 CEET Notification Dashboard

Ce projet est une application Laravel 12 développée dans le cadre d’un stage au sein de la **CEET**, une entreprise publique togolaise spécialisée dans la distribution d’électricité. Il simule l’envoi de notifications par email aux clients lors de leur migration, avec une interface simple et un backend structuré.

---

## 🚀 Fonctionnalités principales

- Envoi de notifications **par email** via Maildev
- Stockage des clients en **base de données uniquement**
- Interface HTML/CSS avec Alpine.js pour les interactions
- Comptes de test préconfigurés pour la démonstration

---

## 🛠️ Technologies utilisées

- Laravel 12
- PostgreSQL
- HTML, CSS
- Alpine.js
- Maildev (pour les emails de test)

---

## ⚙️ Installation locale

```bash
git clone https://github.com/ton-projet.git
cd ton-projet
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan serve

👥 Comptes de test
Tous les comptes utilisent le mot de passe par défaut password.
- Le compte administrateur utilise l’adresse : admin@ceet.test
- Le compte gestionnaire utilise l’adresse : gestionnaire@ceet.test
- Le compte technicien utilise l’adresse : technicien@ceet.test
Ces identifiants sont réservés aux tests en local et à la démonstration technique.
Les clients sont enregistrés uniquement en base de données et ne sont pas affichés dans l’interface
