# 🧾 Invoice & Payment API

A RESTful API for managing invoices and payments, built with Laravel 11 and JWT authentication. Designed for SMEs and freelancers who need a reliable backend for their billing system.

---

## ✨ Features

- 🔐 JWT Authentication (Register / Login)
- 🧾 Full Invoice CRUD (Create, Read, Update status)
- 💰 Total calculation from line items automatically
- 📊 Dashboard summary (revenue, unpaid, by status)
- 🗄️ MySQL database with proper relationships
- 🔒 User-scoped data (each user sees only their own invoices)

---

## 🚀 Getting Started

### Requirements

- PHP 8.1+
- Composer
- MySQL 8.x
- Laravel 11.x

### Installation

**1. Clone the repository**

```bash
git clone https://github.com/vasinch90/invoice-api.git
cd invoice-api
```

**2. Install dependencies**

```bash
composer install
```

**3. Copy environment file**

```bash
cp .env.example .env
```

**4. Configure `.env`**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=invoice_api
DB_USERNAME=root
DB_PASSWORD=your_password
```

**5. Generate keys**

```bash
php artisan key:generate
php artisan jwt:secret
```

**6. Run migrations**

```bash
php artisan migrate
```

**7. Start the server**

```bash
php artisan serve
```

API is now running at `http://127.0.0.1:8000` ✅

---

## 📋 API Endpoints

### Auth

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/auth/register` | Register new user |
| POST | `/api/auth/login` | Login and get token |

### Invoices

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/invoices` | List all invoices |
| POST | `/api/invoices` | Create new invoice |
| GET | `/api/invoices/{id}` | Get invoice detail |
| PUT | `/api/invoices/{id}/status` | Update invoice status |

### Dashboard

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/dashboard/summary` | Revenue & status summary |

> All endpoints except Auth require `Authorization: Bearer {token}` header.

---

## 📖 Usage Examples

### Register

```bash
curl -X POST http://127.0.0.1:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Ben Dev",
    "email": "ben@example.com",
    "password": "password123"
  }'
```

**Response**

```json
{
  "message": "Registered successfully",
  "token": "eyJ0eXAiOiJKV1Qi..."
}
```

---

### Create Invoice

```bash
curl -X POST http://127.0.0.1:8000/api/invoices \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "client_name": "ABC Company Ltd.",
    "client_email": "abc@company.com",
    "items": [
      { "name": "Web Development", "qty": 1, "price": 15000 },
      { "name": "Bug Fixing", "qty": 3, "price": 2000 }
    ],
    "due_date": "2026-06-01"
  }'
```

**Response**

```json
{
  "message": "Invoice created",
  "invoice": {
    "id": 1,
    "invoice_number": "INV-ABC123",
    "client_name": "ABC Company Ltd.",
    "client_email": "abc@company.com",
    "items": [
      { "name": "Web Development", "qty": 1, "price": 15000 },
      { "name": "Bug Fixing", "qty": 3, "price": 2000 }
    ],
    "total": 21000,
    "status": "sent",
    "due_date": "2026-06-01",
    "created_at": "2026-05-08T10:00:00.000000Z"
  }
}
```

---

### Dashboard Summary

```bash
curl http://127.0.0.1:8000/api/dashboard/summary \
  -H "Authorization: Bearer {token}"
```

**Response**

```json
{
  "total_invoices": 5,
  "total_revenue": 45000,
  "unpaid_amount": 21000,
  "by_status": {
    "draft": 1,
    "sent": 2,
    "paid": 2,
    "overdue": 0
  },
  "recent": [...]
}
```

---

## 🗄️ Database Schema

```
users
├── id
├── name
├── email (unique)
├── password
└── timestamps

invoices
├── id
├── user_id (FK → users)
├── invoice_number (unique)
├── client_name
├── client_email
├── items (JSON)
├── total (decimal)
├── status (draft|sent|paid|overdue)
├── due_date
├── payment_id (nullable)
└── timestamps
```

---

## 🔒 Authentication

This API uses **JWT (JSON Web Token)** for authentication.

1. Register or Login to get a token
2. Include the token in every request header:

```
Authorization: Bearer eyJ0eXAiOiJKV1Qi...
```

Tokens expire after **7 days**.

---

## 📬 Postman Collection

Import the collection to test all endpoints quickly:

> 📥 [Download Postman Collection](./postman/invoice-api.json)

---

## 🛣️ Roadmap

- [ ] PDF export for invoices
- [ ] Omise payment gateway integration
- [ ] Stripe payment gateway integration
- [ ] Email notification on invoice sent
- [ ] Overdue invoice auto-detection

---

## 👨‍💻 Author

**Ben Dev** — Full-stack PHP & Node.js Developer (5+ years)

- Fiverr: [fiverr.com/your-username](https://fiverr.com/your-username)
- GitHub: [github.com/your-username](https://github.com/your-username)

---

## 📄 License

MIT License — feel free to use this project as a reference.