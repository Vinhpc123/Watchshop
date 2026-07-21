# ⌚ WatchStore E-Commerce Platform

![PHP](https://img.shields.io/badge/PHP-8.1-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Enabled-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![CI/CD](https://img.shields.io/badge/CI%2FCD-GitHub_Actions-2088FF?style=for-the-badge&logo=githubactions&logoColor=white)

A high-performance, responsive E-commerce platform built for luxury watch retail. Features real-time stock control, secure authentication, mobile-first Apple-style UI, Schema.org SEO integration, and Docker containerization.

---

## 🎯 Resume Impact & Highlights (For Axon & Tech Product Companies)

- **Impact & Scale:** Engineered full-stack retail flow handling product discovery, shopping cart synchronization, and inventory management with optimized SQL queries (`COUNT(*)`, prepared statements) to prevent race conditions during checkout.
- **Mobile-First UX:** Refactored UI architecture using CSS Fluid Grid & Flexbox following Apple Human Interface Guidelines (44px touch targets), eliminating horizontal overflow across 320px–1920px viewports.
- **SEO & Search Visibility:** Implemented Schema.org (`Product`/`Offer`) microdata for Google Rich Snippets & Lazy Loading for Web Vitals performance.
- **Security & Quality:** Mitigated XSS vulnerabilities (`htmlspecialchars`) and SQL Injection risks; enforced automated CI/CD syntax checks via GitHub Actions.
- **DevOps Ready:** Fully containerized with `Dockerfile` and `docker-compose.yml` for 1-click deployment.

---

## 🚀 1-Click Setup with Docker

Ensure you have [Docker](https://www.docker.com/) installed, then run:

```bash
docker-compose up -d
```

Access the application in your browser:
- **Web App:** `http://localhost:8080`
- **Database:** MySQL on `localhost:3306` (Pre-loaded with `laptrinhweb.sql`)

To stop the containers:
```bash
docker-compose down
```

---

## 🛠️ Tech Stack & Architecture

- **Backend:** PHP 8.1 (Procedural / Modular), MySQL 8.0
- **Frontend:** Vanilla HTML5, CSS3 (Modern Flexbox/Grid), JavaScript (ES6+)
- **DevOps:** Docker, Docker Compose, GitHub Actions (CI/CD Pipeline)
- **Standards:** W3C Semantic HTML, Schema.org Microdata, OWASP Security Practices
