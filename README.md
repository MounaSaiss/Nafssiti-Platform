# 🧠 Nafssiti — Mental Health Care Platform

**Nafssiti** (نفسيتي — "my psychology/mental state" in Arabic) is a web platform that connects patients with licensed psychologists. It solves the problem of fragmented mental healthcare management by providing a single space where patients can find a therapist, book appointments, pay online, and track their therapy progress — while psychologists can manage their schedule, follow up with patients, and maintain clinical records.

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 12 (PHP 8.2) |
| Frontend | Blade Templates + Tailwind CSS v4 |
| Database | MySQL |
| Payments | Stripe API |
| Video Meetings | Jitsi Meet (embedded) |
| Calendar | FullCalendar.js v6 |
| Build Tool | Vite |

---

## ✨ Features

### 👤 Authentication & Roles
- Separate registration flows for **patients** and **psychologists**
- Role-based access control with dedicated middleware (Admin / Patient / Psychologist)
- Login, logout, and profile management for all roles

### 🔍 Patient Features
- Browse and discover all registered psychologists
- Book appointments (reservation) with available psychologists
- Online payment via **Stripe** (checkout, success, cancel flows)
- View upcoming and past appointments (`rendez-vous`)
- Send follow-up requests to psychologists after sessions
- Access a personal **shared room** (clinical space) with their psychologist
- View session summaries (`bilan de séance`)
- Update personal profile

### 🧑‍⚕️ Psychologist Features
- Dashboard with appointment overview
- Interactive **calendar** (FullCalendar) with event management
- Accept, refuse, or complete appointment requests
- Set unavailability slots to block off time
- Manage a **patient dossier (shared room)** per patient:
  - Update patient clinical info
  - Add/delete private notes
  - Set therapeutic objectives and track their status
  - Write recommendations
  - Directly schedule follow-up appointments
- View appointment history
- Manage follow-up requests (accept/reject)
- Update professional profile

### 🛡️ Admin Features
- Admin dashboard
- User management (view and manage all users)
- Appointment management and oversight

### 📹 Video Consultations
- In-platform video meetings via **Jitsi** (unique room ID per appointment)

---

## 🗄️ Database Models

`User`, `Patient`, `Psychologist`, `Admin`, `Appointment`, `Payment`, `FollowRequest`, `Unavailability`, `TherapeuticObjective`, `Recommendation`, `Certificate`, `Notification`, `Role`

---

The `composer run dev` command concurrently starts:
- `php artisan serve` → Laravel app at `http://localhost:8000`
- `npm run dev` → Vite asset bundler
- `php artisan queue:listen` → Background job queue

### Environment Variables to Configure

| Variable | Description |
|---|---|
| `DB_DATABASE` | MySQL database name (`nafssiti`) |
| `DB_USERNAME` | MySQL username |
| `DB_PASSWORD` | MySQL password |
| `STRIPE_KEY` | Stripe publishable key |
| `STRIPE_SECRET` | Stripe secret key |

---

## 🎯 Project Goal

This is a **full-stack school / portfolio project** built to practice:
- Full-stack Laravel development (MVC architecture, middleware, form requests, services)
- Role-based authentication and authorization
- Third-party API integration (Stripe for payments, Jitsi for video)
- Real-world domain modeling (healthcare, appointments, clinical records)
- Responsive UI design with Tailwind CSS

---

## 👩‍💻 Author

**Mouna Saiss** — Computer Science Engineering Student
