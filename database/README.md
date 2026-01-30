# Database Setup Guide 🗄️

This directory contains all the necessary files to restructure, migrate, and seed the Jasa Raharja Dashboard database.

## 🚀 Quick Start

### 1. Prerequisites
Ensure your `.env` is configured correctly:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_insurance_dashboard
DB_USERNAME=root      # Required for creating Triggers/SPs
DB_PASSWORD=root
```

> **Note:** The database user must have `SUPER` privileges or `log_bin_trust_function_creators` enabled to create Triggers.

### 2. Run Migrations & Seeders
To build the database from scratch and populate it with master data:

```bash
php artisan migrate:fresh --seed
```

This single command will:
1. Drop all existing tables.
2. Run all migrations (creating tables, FKs, SPs, Views, Triggers).
3. Execute `MasterDataSeeder` to import `insurance_master_data.sql`.

### 3. Verify Installation
Run the following checks to ensure everything is installed correctly:

```bash
# Check if tables exist
php artisan migrate:status

# Check if admin user exists
php artisan tinker --execute="App\Models\User::where('username', 'admin')->first();"
```

## 🛠️ Troubleshooting

**Issue: `SQLSTATE[HY000]: General error: 1419 You do not have the SUPER privilege...`**
- **Cause:** MySQL binary logging prevents trigger creation.
- **Fix:** Enable trust function creators in MySQL:
  ```sql
  SET GLOBAL log_bin_trust_function_creators = 1;
  ```
  Or ensure you are using the `root` user in `.env`.

**Issue: `Foreign key constraint incorrectly formed`**
- **Cause:** Migration order is incorrect.
- **Fix:** Ensure migration filenames generally follow the phase order (Master -> Users -> Transactions). The current timestamps are already ordered correctly.
