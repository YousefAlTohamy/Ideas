# Ideas - A Social Idea Sharing Platform

Ideas is a social media web app built with Laravel.  
Users share, discover, and interact with ideas through a clean interface.  
The app includes a RESTful API, an admin dashboard, and performance optimizations.

---

## Key Features

### User & Social Features
- **Authentication** – Secure registration and login  
- **Welcome Emails** – Sent automatically via Laravel Queues  
- **Idea Management** – Create, view, edit, and delete ideas with preserved formatting  
- **Dynamic Actions** – Like/unlike and follow/unfollow without reloading the page (AJAX)  
- **Profiles** – Display bio, ideas, and stats (followers, following, ideas, comments, likes)  
- **Profile Customization** – Upload and update profile pictures, edit bio  
- **Personalized Feed** – Shows ideas from followed users  
- **Top Users** – Discover popular creators  
- **Search** – Find users by name or username  

### Admin Dashboard
- **Statistics** – Widgets for total counts (Admins, Users, Ideas, Comments)  
- **User Management** – List, search, delete, promote/demote users  
- **Inline Editing** – Edit name, username, or email directly in the table (AJAX)  
- **Idea & Comment Management** – View and delete any idea or comment  
- **AJAX Tables** – Seamless updates for actions like delete or status changes  

### RESTful API
- **Token-Based Auth** – Secured with Laravel Sanctum  
- **CRUD for Ideas** – Endpoints for create, read, update, delete  
- **Social Endpoints** – Like/unlike, follow/unfollow, post/delete comments  
- **User Endpoints** – Fetch profiles, followers, and followings  
- **API Resources** – Clean JSON output using Laravel Resources  

---

## Technical Deep Dive

### 1. Performance Optimization
- **Eager Loading** – Used in controllers to reduce N+1 queries  
- **Model-Level Eager Loading** – `$with` property on Idea model auto-loads author  
- **Targeted Controller Loading** – Avoids redundant nested relationships  
- **In-Memory Checks** – Uses collection `.contains()` instead of queries in Blade  

### 2. Queues for Asynchronous Tasks
- **Welcome Emails** – Sent in the background using `SendWelcomeEmailJob`  
- **Queue Worker** – Runs continuously (`php artisan queue:work`)  
- **Supervisor** – Used in production to manage queue processes  

### 3. AJAX for Dynamic Frontend
- **Like/Follow Actions** – AJAX updates database and UI instantly  
- **Admin Panel** – Uses AJAX for delete and status updates without reload  

---

## Setup and Installation

### Prerequisites
- PHP >= 8.1  
- Composer  
- Node.js & NPM  
- Database (MySQL recommended)  

### 1. Clone Repository
```bash
git clone https://github.com/YousefAlTohamy/Ideas.git
cd Ideas
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Configure Environment
```bash
cp .env.example .env
php artisan key:generate
```
- Update database credentials in `.env`  
- Update mail configuration (see Mail Server Setup below)  

### 4. Run Migrations
```bash
php artisan migrate
```

### 5. Link Storage
```bash
php artisan storage:link
```

### 6. Compile Assets
```bash
npm run dev
```
Use `npm run build` for production.

---

## Running the Project

### 1. Configure Mail Server
For Gmail SMTP:
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-16-character-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"
```
Then clear config:
```bash
php artisan config:clear
```

### 2. Run Development Servers
Install concurrently if missing:
```bash
npm install concurrently --save-dev
```

Add this to `package.json`:
```json
"scripts": {
  "start": "concurrently \"php artisan serve\" \"php artisan queue:work\""
}
```

Run both servers:
```bash
npm run start
```

App runs at:
```
http://127.0.0.1:8000
```
Queue worker stays active to process jobs.

---

## Contact
**Developer:** Yousef Al Tohamy Ahmed  
**Email:** youseftohtoh46@gmail.com  
**LinkedIn:** [linkedin.com/in/yousefaltohamy](https://linkedin.com/in/yousefaltohamy)  
**GitHub:** [github.com/YousefAlTohamy](https://github.com/YousefAlTohamy)
