# 🎓 Student Management System — DevOps-Driven 3-Tier Architecture

## 🚀 Overview

This project is a **production-style, containerized 3-tier web application** built for learning and demonstrating **modern DevOps practices**.

It showcases how to design, develop, containerize, and prepare a full-stack system for **cloud deployment (AWS ECS + RDS)** using industry-standard tools.

---

## 🧱 Architecture (3-Tier Design)

```
Client (Browser / API Consumer)
        ↓
Nginx (Reverse Proxy)
        ↓
Laravel API (PHP-FPM Container)
        ↓
MySQL (Database Container / AWS RDS)
```

### 🔹 Key Components

* **Frontend Layer (Future)** → Vue.js (to be hosted on S3)
* **Application Layer** → Laravel REST API (Docker container)
* **Database Layer** → MySQL (Docker → AWS RDS)

---

## ⚙️ Tech Stack

### 🔹 Backend

* PHP 8.4
* Laravel 13 (API-first architecture)

### 🔹 Infrastructure

* Docker & Docker Compose
* Nginx (reverse proxy)
* MySQL 8

### 🔹 DevOps & Cloud (Planned / In Progress)

* Git & GitHub
* GitHub Actions (CI/CD)
* AWS ECS (Container orchestration)
* AWS ECR (Container registry)
* AWS RDS (Managed database)

---

## 📦 Features

### ✅ Core System

* Student Management
* Instructor Management
* Course Management
* Enrollment System

### ✅ API Capabilities

* RESTful API (CRUD operations)
* Structured JSON responses
* Relational data handling (Eloquent ORM)

---

## 🧩 Database Design

### Tables:

* `users`
* `students`
* `instructors`
* `courses`
* `enrollments`

### Relationships:

* One User → One Student Profile
* One Instructor → Many Courses
* Many Students ↔ Many Courses (via Enrollments)

---

## 🐳 Containerized Setup

### Services:

* `app` → Laravel (PHP-FPM)
* `nginx` → Web server
* `mysql` → Database

### Run Project

```bash
docker compose up -d --build
```

---

## 🧪 Access Application

* Web: http://localhost:8000
* API: http://localhost:8000/api/students

---

## 🔧 Environment Configuration

Example `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=student_db
DB_USERNAME=root
DB_PASSWORD=root
```

---

## 🧪 Database Setup

### Run migrations:

```bash
docker exec -it laravel-app-1 php artisan migrate
```

---

## 📁 Project Structure

```
student-system/
├── backend/            # Laravel application
├── docker/
│   ├── nginx/          # Nginx configuration
│   └── php/            # PHP Dockerfile
├── docker-compose.yml
├── .gitignore
└── README.md
```

---

## 🔐 DevOps Practices Implemented

* ✅ Infrastructure as Code (Docker + Compose)
* ✅ Environment-based configuration
* ✅ Separation of concerns (app vs infra)
* ✅ Containerized development environment
* ✅ Version control with Git & GitHub

---

## 🚀 CI/CD Pipeline (Planned)

Future pipeline will include:

1. Push code to GitHub
2. GitHub Actions build Docker image
3. Push image to AWS ECR
4. Deploy to AWS ECS
5. Connect to AWS RDS

---

## ☁️ Cloud Deployment Plan

| Layer    | AWS Service   |
| -------- | ------------- |
| Frontend | S3            |
| Backend  | ECS (Fargate) |
| Database | RDS           |
| Registry | ECR           |

---

## 🧠 Key Learning Outcomes

This project demonstrates:

* Containerized application development
* Multi-service orchestration with Docker
* REST API design with Laravel
* Debugging real-world infrastructure issues
* Preparing applications for cloud-native deployment

---

## 🔥 Challenges Solved

* Docker container networking (Nginx ↔ PHP-FPM)
* Volume mounting issues
* File permission handling inside containers
* Laravel configuration debugging
* Nginx reverse proxy setup

---

## 🛠️ Future Enhancements

* JWT / Sanctum Authentication
* Role-based access control (RBAC)
* Vue.js frontend integration
* API rate limiting
* Logging & monitoring
* CI/CD full automation
* Production deployment on AWS

---

## 👨‍💻 Author

**Ali Mohamed**

* DevOps & Cloud Learning Project
* Focus: Real-world backend + infrastructure design

---

## ⭐ Project Goal

To build a **real-world, production-ready system** that demonstrates:

> “From development → containerization → CI/CD → cloud deployment”

---

## 📌 Notes

This project is designed as a **learning-by-building DevOps portfolio**, following practices used in modern software engineering teams.

---
