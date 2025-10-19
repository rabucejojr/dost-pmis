# 🏛️ DOST-PMIS  
**Department of Science and Technology – Project Management Information System**

DOST-PMIS is a web-based information system designed to streamline the management, monitoring, and reporting of programs and projects implemented under the Department of Science and Technology (DOST).  
It serves as a centralized platform for tracking project progress, milestones, financial utilization, and document submissions across multiple programs.

---

## 🚀 Features

### 🗂️ Program & Project Management
- Create and manage **Programs** and their corresponding **Projects**  
- Assign **project leaders, implementers**, and **status updates**  
- Define **budget allocations** and **project duration**

### 📊 Monitoring & Reporting
- Track **project progress** and performance indicators  
- Generate **program- and project-level summaries**  
- Export reports in various formats (PDF, CSV, Excel)

### 👥 User Roles & Access Control
- **Admin** – Full control over programs, projects, and users  
- **Staff/User** – Limited access for project encoding and monitoring  
- **Guest** – Read-only dashboard for public transparency

### 📁 Document Management
- Upload, view, and download project-related documents  
- Track document version history and submission timelines  

### 🧾 Audit & Logs
- Record user activities (create, update, delete actions)  
- Timestamped logs for accountability and compliance  

---

## 🧩 System Architecture

DOST-PMIS follows a **modular architecture** with a **single, unified database** design for all programs and projects.

### Database Design Overview
| Table | Description |
|--------|--------------|
| `programs` | Stores details of all DOST programs |
| `projects` | Linked to `programs`, contains project-level information |
| `activities` | Tracks project activities, milestones, and progress |
| `users` | Holds user accounts and roles |
| `documents` | Manages project-related files |
| `logs` | Records all system activities |

> **Note:** Data integrity is enforced through relational foreign keys and cascading rules.

---

## 🛠️ Tech Stack

| Layer | Technology |
|--------|-------------|
| **Backend** | Laravel 12 (PHP 8.3) |
| **Frontend** | Vue.js 3 (Composition API + Vite) |
| **Styling** | Tailwind CSS 3 + ShadCN UI Components |
| **Authentication** | Spatie |
| **Database** | MySQL 8.x |
| **Version Control** | Git + GitHub |
| **Deployment** | Apache/Nginx + PHP-FPM |

---

## ⚙️ Installation & Setup

### Prerequisites
- PHP ≥ 8.3  
- Composer  
- Node.js ≥ 18  
- MySQL ≥ 8  
- Git  

### Steps
```bash
# Clone the repository
git clone https://github.com/rabucejojr/dost-pmis.git
cd dost-pmis

# Install backend dependencies
composer install

# Install frontend dependencies
npm install && npm run dev

# Copy and configure environment file
cp .env.example .env
php artisan key:generate

# Run migrations and seeders
php artisan migrate --seed

# Start local development server
php artisan serve
