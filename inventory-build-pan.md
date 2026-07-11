# Inventrix — Full Inventory Management Panel

> **Tech Stack:** Laravel 12, Tailwind CSS v4, Vite, MySQL/PostgreSQL/SQLite  
> **Build Order:** Documented from project creation through all feature pages

---

## Table of Contents

1. [Project Setup](#1-project-setup)
2. [Database Schema](#2-database-schema)
3. [Models](#3-models)
4. [Controllers & Services](#4-controllers--services)
5. [Layout & Sidebar](#5-layout--sidebar)
6. [Routes](#6-routes)
7. [Feature Pages (Build Order)](#7-feature-pages-build-order)
8. [Blade View Reference](#8-blade-view-reference)
9. [Commands Quick Reference](#9-commands-quick-reference)

---

## 1. Project Setup

### 1.1 Create Laravel Project

```bash
composer create-project laravel/laravel inventrix
cd inventrix
```

### 1.2 Install & Configure Tailwind CSS v4 with Vite

**composer.json** — default Laravel 12 packages:

```json
"require": {
    "php": "^8.2",
    "laravel/framework": "^12.0",
    "laravel/tinker": "^2.10.1"
}
```

**package.json** — dev dependencies:

```json
"devDependencies": {
    "@tailwindcss/vite": "^4.0.0",
    "axios": "^1.11.0",
    "concurrently": "^9.0.1",
    "laravel-vite-plugin": "^2.0.0",
    "tailwindcss": "^4.0.0",
    "vite": "^7.0.7"
}
```

Install npm packages:

```bash
npm install
```

**`vite.config.js`:**

```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
```

**`resources/css/app.css`:**

```css
@import 'tailwindcss';

@source '../../vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php';
@source '../../storage/framework/views/*.php';
@source '../**/*.blade.php';
@source '../**/*.js';

@theme {
    --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji',
        'Segoe UI Symbol', 'Noto Color Emoji';
}
```

### 1.3 Install Font

Add to layout `<head>`:

```html
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
```

### 1.4 Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Configure your database in `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventrix
DB_USERNAME=root
DB_PASSWORD=
```

### 1.5 Run Migrations

```bash
php artisan migrate
```

### 1.6 Build Frontend

```bash
npx vite build
```

For development with live reload:

```bash
npx vite dev
# In another terminal:
php artisan serve
```

---

## 2. Database Schema

All tables, columns, relationships, and indexes. Create migrations in this order.

### 2.1 `users` (Laravel default + additions)

| Column | Type | Attributes |
|--------|------|------------|
| id | bigIncrements | PK |
| name | string(255) | |
| email | string(255) | unique |
| email_verified_at | timestamp | nullable |
| password | string(255) | |
| remember_token | string(100) | nullable |
| phone | string(20) | nullable |
| avatar | string(255) | nullable |
| role | enum('admin','manager','staff') | default 'staff' |
| status | enum('active','inactive') | default 'active' |
| last_login_at | timestamp | nullable |
| created_at | timestamp | |
| updated_at | timestamp | |

**Relationships:**
- Has many `ActivityLog` entries
- Has many `Orders` (as assigned user)
- Has many `PurchaseOrders` (as created by)

### 2.2 `categories`

| Column | Type | Attributes |
|--------|------|------------|
| id | bigIncrements | PK |
| name | string(255) | |
| slug | string(255) | unique |
| description | text | nullable |
| created_at | timestamp | |
| updated_at | timestamp | |

**Relationships:**
- Has many `Products`

### 2.3 `brands`

| Column | Type | Attributes |
|--------|------|------------|
| id | bigIncrements | PK |
| name | string(255) | |
| slug | string(255) | unique |
| description | text | nullable |
| website | string(255) | nullable |
| status | enum('active','inactive') | default 'active' |
| created_at | timestamp | |
| updated_at | timestamp | |

**Relationships:**
- Has many `Products`

### 2.4 `warehouses`

| Column | Type | Attributes |
|--------|------|------------|
| id | bigIncrements | PK |
| name | string(255) | |
| address | text | |
| capacity | integer | |
| occupied | integer | default 0 |
| manager | string(255) | nullable |
| status | enum('active','maintenance','inactive') | default 'active' |
| created_at | timestamp | |
| updated_at | timestamp | |

**Relationships:**
- Has many `StockItems`

### 2.5 `products`

| Column | Type | Attributes |
|--------|------|------------|
| id | bigIncrements | PK |
| name | string(255) | |
| sku | string(100) | unique |
| description | text | nullable |
| price | decimal(10,2) | |
| cost_price | decimal(10,2) | nullable |
| category_id | bigInteger | FK -> categories.id |
| brand_id | bigInteger | nullable, FK -> brands.id |
| image | string(255) | nullable |
| min_stock | integer | default 10 |
| status | enum('active','inactive','discontinued') | default 'active' |
| created_at | timestamp | |
| updated_at | timestamp | |

**Indexes:** `index on category_id`, `index on brand_id`, `unique on sku`

**Relationships:**
- Belongs to `Category`
- Belongs to `Brand`
- Has many `StockItems`
- Has many `OrderItems`
- Has many `PurchaseOrderItems`
- Has many `StockAdjustments`

### 2.6 `stock_items` (inventory per product per warehouse)

| Column | Type | Attributes |
|--------|------|------------|
| id | bigIncrements | PK |
| product_id | bigInteger | FK -> products.id |
| warehouse_id | bigInteger | FK -> warehouses.id |
| quantity | integer | default 0 |
| min_stock | integer | default 10 |
| created_at | timestamp | |
| updated_at | timestamp | |

**Indexes:** `unique on (product_id, warehouse_id)`

**Relationships:**
- Belongs to `Product`
- Belongs to `Warehouse`

### 2.7 `customers`

| Column | Type | Attributes |
|--------|------|------------|
| id | bigIncrements | PK |
| name | string(255) | |
| email | string(255) | unique |
| phone | string(20) | nullable |
| avatar | string(255) | nullable |
| address | text | nullable |
| status | enum('active','inactive') | default 'active' |
| total_orders | integer | default 0 |
| total_spent | decimal(12,2) | default 0 |
| created_at | timestamp | |
| updated_at | timestamp | |

**Relationships:**
- Has many `Orders`
- Has many `Invoices`

### 2.8 `suppliers`

| Column | Type | Attributes |
|--------|------|------------|
| id | bigIncrements | PK |
| company_name | string(255) | |
| contact_person | string(255) | |
| email | string(255) | |
| phone | string(20) | nullable |
| address | text | nullable |
| category | string(255) | nullable (e.g. Electronics, Raw Materials) |
| product_count | integer | default 0 |
| status | enum('active','pending','inactive') | default 'active' |
| created_at | timestamp | |
| updated_at | timestamp | |

**Relationships:**
- Has many `PurchaseOrders`

### 2.9 `orders`

| Column | Type | Attributes |
|--------|------|------------|
| id | bigIncrements | PK |
| order_number | string(50) | unique |
| customer_id | bigInteger | FK -> customers.id |
| user_id | bigInteger | nullable, FK -> users.id (assigned staff) |
| total_items | integer | default 0 |
| subtotal | decimal(12,2) | |
| tax | decimal(12,2) | default 0 |
| total | decimal(12,2) | |
| payment_method | string(50) | nullable |
| payment_status | enum('pending','paid','failed','refunded') | default 'pending' |
| status | enum('pending','processing','completed','cancelled') | default 'pending' |
| notes | text | nullable |
| ordered_at | timestamp | |
| created_at | timestamp | |
| updated_at | timestamp | |

**Indexes:** `index on customer_id`, `unique on order_number`

**Relationships:**
- Belongs to `Customer`
- Belongs to `User` (nullable)
- Has many `OrderItems`
- Has many `Invoices`
- Has many `Returns`
- Has many `Shipments`

### 2.10 `order_items`

| Column | Type | Attributes |
|--------|------|------------|
| id | bigIncrements | PK |
| order_id | bigInteger | FK -> orders.id |
| product_id | bigInteger | FK -> products.id |
| quantity | integer | |
| unit_price | decimal(10,2) | |
| total | decimal(12,2) | |
| created_at | timestamp | |
| updated_at | timestamp | |

**Indexes:** `index on order_id`, `index on product_id`

**Relationships:**
- Belongs to `Order`
- Belongs to `Product`

### 2.11 `invoices`

| Column | Type | Attributes |
|--------|------|------------|
| id | bigIncrements | PK |
| invoice_number | string(50) | unique |
| order_id | bigInteger | nullable, FK -> orders.id |
| customer_id | bigInteger | FK -> customers.id |
| amount | decimal(12,2) | |
| tax | decimal(12,2) | default 0 |
| total | decimal(12,2) | |
| issue_date | date | |
| due_date | date | |
| status | enum('paid','pending','overdue','draft','cancelled') | default 'draft' |
| notes | text | nullable |
| created_at | timestamp | |
| updated_at | timestamp | |

**Indexes:** `index on order_id`, `index on customer_id`, `unique on invoice_number`

**Relationships:**
- Belongs to `Order` (nullable)
- Belongs to `Customer`

### 2.12 `purchase_orders`

| Column | Type | Attributes |
|--------|------|------------|
| id | bigIncrements | PK |
| po_number | string(50) | unique |
| supplier_id | bigInteger | FK -> suppliers.id |
| user_id | bigInteger | nullable, FK -> users.id |
| total_items | integer | default 0 |
| subtotal | decimal(12,2) | |
| tax | decimal(12,2) | default 0 |
| total | decimal(12,2) | |
| order_date | date | |
| delivery_date | date | nullable |
| status | enum('pending','approved','shipped','received','cancelled') | default 'pending' |
| notes | text | nullable |
| created_at | timestamp | |
| updated_at | timestamp | |

**Indexes:** `index on supplier_id`, `unique on po_number`

**Relationships:**
- Belongs to `Supplier`
- Belongs to `User` (nullable)
- Has many `PurchaseOrderItems`

### 2.13 `purchase_order_items`

| Column | Type | Attributes |
|--------|------|------------|
| id | bigIncrements | PK |
| purchase_order_id | bigInteger | FK -> purchase_orders.id |
| product_id | bigInteger | FK -> products.id |
| quantity | integer | |
| unit_price | decimal(10,2) | |
| total | decimal(12,2) | |
| created_at | timestamp | |
| updated_at | timestamp | |

**Indexes:** `index on purchase_order_id`, `index on product_id`

**Relationships:**
- Belongs to `PurchaseOrder`
- Belongs to `Product`

### 2.14 `returns`

| Column | Type | Attributes |
|--------|------|------------|
| id | bigIncrements | PK |
| return_number | string(50) | unique |
| order_id | bigInteger | FK -> orders.id |
| customer_id | bigInteger | FK -> customers.id |
| total_items | integer | default 0 |
| amount | decimal(12,2) | |
| reason | text | |
| status | enum('pending','approved','rejected','refunded') | default 'pending' |
| created_at | timestamp | |
| updated_at | timestamp | |

**Indexes:** `index on order_id`, `index on customer_id`, `unique on return_number`

**Relationships:**
- Belongs to `Order`
- Belongs to `Customer`

### 2.15 `shipments`

| Column | Type | Attributes |
|--------|------|------------|
| id | bigIncrements | PK |
| tracking_number | string(100) | unique |
| order_id | bigInteger | FK -> orders.id |
| carrier | string(100) | |
| origin | string(255) | |
| destination | string(255) | nullable |
| status | enum('preparing','shipped','in_transit','delivered','delayed') | default 'preparing' |
| estimated_delivery | date | nullable |
| actual_delivery | date | nullable |
| notes | text | nullable |
| created_at | timestamp | |
| updated_at | timestamp | |

**Indexes:** `index on order_id`, `unique on tracking_number`

**Relationships:**
- Belongs to `Order`

### 2.16 `stock_adjustments`

| Column | Type | Attributes |
|--------|------|------------|
| id | bigIncrements | PK |
| reference | string(50) | unique |
| product_id | bigInteger | FK -> products.id |
| warehouse_id | bigInteger | FK -> warehouses.id |
| type | enum('addition','deduction','transfer') | |
| quantity | integer | |
| target_warehouse_id | bigInteger | nullable, FK -> warehouses.id (for transfers) |
| reason | string(255) | |
| created_by | bigInteger | nullable, FK -> users.id |
| created_at | timestamp | |
| updated_at | timestamp | |

**Indexes:** `index on product_id`, `index on warehouse_id`, `unique on reference`

**Relationships:**
- Belongs to `Product`
- Belongs to `Warehouse` (source)
- Belongs to `Warehouse` as `targetWarehouse` (nullable)
- Belongs to `User` as `createdBy`

### 2.17 `expenses`

| Column | Type | Attributes |
|--------|------|------------|
| id | bigIncrements | PK |
| description | string(255) | |
| category | string(100) | |
| amount | decimal(12,2) | |
| payment_method | string(50) | nullable |
| status | enum('paid','pending','cancelled') | default 'paid' |
| expense_date | date | |
| notes | text | nullable |
| created_by | bigInteger | nullable, FK -> users.id |
| created_at | timestamp | |
| updated_at | timestamp | |

**Relationships:**
- Belongs to `User` as `createdBy`

### 2.18 `payments` / `transactions`

| Column | Type | Attributes |
|--------|------|------------|
| id | bigIncrements | PK |
| transaction_id | string(50) | unique |
| order_id | bigInteger | nullable, FK -> orders.id |
| supplier_id | bigInteger | nullable, FK -> suppliers.id |
| type | enum('incoming','outgoing') | |
| amount | decimal(12,2) | |
| payment_method | string(50) | |
| status | enum('completed','pending','failed','refunded') | default 'completed' |
| payer_name | string(255) | nullable |
| payee_name | string(255) | nullable |
| notes | text | nullable |
| transaction_date | date | |
| created_at | timestamp | |
| updated_at | timestamp | |

**Indexes:** `unique on transaction_id`, `index on order_id`, `index on supplier_id`

**Relationships:**
- Belongs to `Order` (nullable)
- Belongs to `Supplier` (nullable)

### 2.19 `tax_rates`

| Column | Type | Attributes |
|--------|------|------------|
| id | bigIncrements | PK |
| name | string(255) | |
| rate | decimal(5,2) | |
| type | enum('percentage','fixed') | default 'percentage' |
| region | string(255) | nullable |
| applies_to | string(255) | nullable (e.g. "All Products", "Electronics") |
| status | enum('active','inactive') | default 'active' |
| created_at | timestamp | |
| updated_at | timestamp | |

### 2.20 `activity_log`

| Column | Type | Attributes |
|--------|------|------------|
| id | bigIncrements | PK |
| user_id | bigInteger | nullable, FK -> users.id |
| action | varchar(50) | (e.g. Created, Updated, Deleted, Transferred) |
| module | varchar(50) | (e.g. Inventory, Sales, Users, Settings) |
| description | text | |
| ip_address | varchar(45) | nullable |
| created_at | timestamp | |

**Indexes:** `index on user_id`, `index on module`

**Relationships:**
- Belongs to `User` (nullable)

### 2.21 `roles` & `role_permissions`

If you want a dynamic permissions system instead of hardcoded checks in the roles view:

**`roles` table:**

| Column | Type | Attributes |
|--------|------|------------|
| id | bigIncrements | PK |
| name | string(50) | unique |
| description | string(255) | nullable |
| created_at | timestamp | |
| updated_at | timestamp | |

**Relationships:** Has many `RolePermissions`, Has many `Users`

**`role_permissions` table:**

| Column | Type | Attributes |
|--------|------|------------|
| id | bigIncrements | PK |
| role_id | bigInteger | FK -> roles.id |
| permission | string(100) | (e.g. "view-products", "edit-orders") |
| created_at | timestamp | |
| updated_at | timestamp | |

**Indexes:** `unique on (role_id, permission)`

**Relationships:** Belongs to `Role`

---

## 3. Models

Create models with relationships. Run `php artisan make:model <ModelName> -m` for each.

### 3.1 User Model (`app/Models/User.php`)

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'avatar',
        'role', 'status', 'last_login_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
        ];
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class, 'user_id');
    }

    public function stockAdjustments()
    {
        return $this->hasMany(StockAdjustment::class, 'created_by');
    }
}
```

### 3.2 Category Model

```php
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
```

### 3.3 Brand Model

```php
class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'website', 'status'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
```

### 3.4 Warehouse Model

```php
class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'address', 'capacity', 'occupied',
        'manager', 'status',
    ];

    public function stockItems()
    {
        return $this->hasMany(StockItem::class);
    }
}
```

### 3.5 Product Model

```php
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'sku', 'description', 'price', 'cost_price',
        'category_id', 'brand_id', 'image', 'min_stock', 'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function stockItems()
    {
        return $this->hasMany(StockItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function purchaseOrderItems()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function stockAdjustments()
    {
        return $this->hasMany(StockAdjustment::class);
    }
}
```

### 3.6 StockItem Model

```php
class StockItem extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'warehouse_id', 'quantity', 'min_stock'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
```

### 3.7 Customer Model

```php
class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'avatar', 'address',
        'status', 'total_orders', 'total_spent',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function returns()
    {
        return $this->hasMany(ReturnModel::class);
    }
}
```

### 3.8 Supplier Model

```php
class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name', 'contact_person', 'email', 'phone',
        'address', 'category', 'product_count', 'status',
    ];

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}
```

### 3.9 Order Model

```php
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'customer_id', 'user_id', 'total_items',
        'subtotal', 'tax', 'total', 'payment_method',
        'payment_status', 'status', 'notes', 'ordered_at',
    ];

    protected function casts(): array
    {
        return [
            'ordered_at' => 'datetime',
        ];
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function returns()
    {
        return $this->hasMany(ReturnModel::class);
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }
}
```

### 3.10 OrderItem Model

```php
class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'product_id', 'quantity',
        'unit_price', 'total',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
```

### 3.11 Invoice Model

```php
class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number', 'order_id', 'customer_id',
        'amount', 'tax', 'total', 'issue_date',
        'due_date', 'status', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'due_date' => 'date',
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
```

### 3.12 PurchaseOrder Model

```php
class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_number', 'supplier_id', 'user_id', 'total_items',
        'subtotal', 'tax', 'total', 'order_date',
        'delivery_date', 'status', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'order_date' => 'date',
            'delivery_date' => 'date',
        ];
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }
}
```

### 3.13 PurchaseOrderItem Model

```php
class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id', 'product_id', 'quantity',
        'unit_price', 'total',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
```

### 3.14 Return Model

```php
class ReturnModel extends Model
{
    use HasFactory;

    protected $table = 'returns';

    protected $fillable = [
        'return_number', 'order_id', 'customer_id',
        'total_items', 'amount', 'reason', 'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
```

### 3.15 Shipment Model

```php
class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_number', 'order_id', 'carrier', 'origin',
        'destination', 'status', 'estimated_delivery',
        'actual_delivery', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'estimated_delivery' => 'date',
            'actual_delivery' => 'date',
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
```

### 3.16 StockAdjustment Model

```php
class StockAdjustment extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference', 'product_id', 'warehouse_id', 'type',
        'quantity', 'target_warehouse_id', 'reason', 'created_by',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function targetWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'target_warehouse_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
```

### 3.17 Expense Model

```php
class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'description', 'category', 'amount', 'payment_method',
        'status', 'expense_date', 'notes', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'expense_date' => 'date',
        ];
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
```

### 3.18 Payment/Transaction Model

```php
class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id', 'order_id', 'supplier_id', 'type',
        'amount', 'payment_method', 'status', 'payer_name',
        'payee_name', 'notes', 'transaction_date',
    ];

    protected function casts(): array
    {
        return [
            'transaction_date' => 'date',
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
```

### 3.19 TaxRate Model

```php
class TaxRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'rate', 'type', 'region',
        'applies_to', 'status',
    ];
}
```

### 3.20 ActivityLog Model

```php
class ActivityLog extends Model
{
    use HasFactory;

    public $timestamps = false; // We only use created_at

    protected $fillable = [
        'user_id', 'action', 'module',
        'description', 'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

### 3.21 Role Model (optional)

```php
class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function permissions()
    {
        return $this->hasMany(RolePermission::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
```

### 3.22 RolePermission Model (optional)

```php
class RolePermission extends Model
{
    use HasFactory;

    protected $fillable = ['role_id', 'permission'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
```

---

## 4. Controllers & Services

### 4.1 Controller Structure

Create controllers for each module. All routes are GET-only for now (view pages with static/demo data).

```bash
# Create all controllers
php artisan make:controller DashboardController
php artisan make:controller ProductController
php artisan make:controller CategoryController
php artisan make:controller BrandController
php artisan make:controller StockController
php artisan make:controller WarehouseController
php artisan make:controller StockAdjustmentController
php artisan make:controller OrderController
php artisan make:controller InvoiceController
php artisan make:controller ReturnController
php artisan make:controller ShipmentController
php artisan make:controller PurchaseOrderController
php artisan make:controller SupplierController
php artisan make:controller CustomerController
php artisan make:controller ExpenseController
php artisan make:controller PaymentController
php artisan make:controller ReportController
php artisan make:controller TaxRateController
php artisan make:controller ActivityLogController
php artisan make:controller UserController
php artisan make:controller RoleController
php artisan make:controller ProfileController
php artisan make:controller SettingController
```

### 4.2 Example Controller Pattern

Each controller follows the same pattern. Example for `DashboardController`:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalSales = Order::where('status', 'completed')->sum('total');
        $totalOrders = Order::count();
        $lowStockCount = Product::where('stock', '<', 10)->count(); // adjust for your stock logic

        $recentOrders = Order::with('customer')
            ->latest()
            ->take(3)
            ->get();

        $lowStockProducts = Product::where('stock', '<', 10)
            ->take(3)
            ->get();

        return view('dashboard', compact(
            'totalProducts', 'totalSales', 'totalOrders', 'lowStockCount',
            'recentOrders', 'lowStockProducts'
        ));
    }
}
```

### 4.3 Service Layer (Optional)

For complex business logic, create service classes:

```bash
mkdir -p app/Services
```

Example `app/Services/StockService.php`:

```php
<?php

namespace App\Services;

use App\Models\StockItem;
use App\Models\StockAdjustment;

class StockService
{
    public function adjustStock($productId, $warehouseId, $type, $quantity, $reason, $userId, $targetWarehouseId = null)
    {
        $stockItem = StockItem::firstOrCreate(
            ['product_id' => $productId, 'warehouse_id' => $warehouseId],
            ['quantity' => 0, 'min_stock' => 10]
        );

        if ($type === 'addition') {
            $stockItem->increment('quantity', $quantity);
        } elseif ($type === 'deduction') {
            $stockItem->decrement('quantity', $quantity);
        } elseif ($type === 'transfer' && $targetWarehouseId) {
            $stockItem->decrement('quantity', $quantity);
            $targetItem = StockItem::firstOrCreate(
                ['product_id' => $productId, 'warehouse_id' => $targetWarehouseId],
                ['quantity' => 0, 'min_stock' => 10]
            );
            $targetItem->increment('quantity', $quantity);
        }

        $reference = 'ADJ-' . str_pad(StockAdjustment::count() + 1, 4, '0', STR_PAD_LEFT);

        return StockAdjustment::create([
            'reference' => $reference,
            'product_id' => $productId,
            'warehouse_id' => $warehouseId,
            'type' => $type,
            'quantity' => $quantity,
            'target_warehouse_id' => $targetWarehouseId,
            'reason' => $reason,
            'created_by' => $userId,
        ]);
    }
}
```

### 4.4 Route Updates

In `routes/web.php`, replace all closures with controller methods:

```php
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/products', [ProductController::class, 'index'])->name('products');
// ... etc for all routes
```

---

## 5. Layout & Sidebar

### 5.1 Main Layout (`resources/views/layouts/panel.blade.php`)

This is the master layout wrapped around every panel page.

**Key Structure:**
- `<head>` with title, fonts, Vite assets (`@vite(['resources/css/app.css', 'resources/js/app.js'])`)
- Inline `<style>` for sidebar behavior (collapse, submenu animations, active states)
- `@include('layouts.sidebar')` — the sidebar
- `#topbar` — fixed top bar with notification bell + user dropdown
- `#mainContent` — content area with `@yield('content')`
- Inline `<script>` on `DOMContentLoaded` for:
  - Sidebar expand/collapse toggle
  - Mobile sidebar overlay
  - User dropdown toggle
  - Notification dropdown toggle
  - Submenu open/close with `.sidebar-submenu` max-height
  - Arrow rotation (90°)
  - Auto-open parent submenu when child route is active via `data-active-route`

**CSS Classes for Sidebar States:**
| Class | Effect |
|-------|--------|
| `.sidebar-expanded` | width: 260px |
| `.sidebar-collapsed` | width: 72px, hides text/arrows |
| `.main-content-expanded` | margin-left: 260px |
| `.main-content-collapsed` | margin-left: 72px |
| `.topbar-expanded` | left: 260px |
| `.topbar-collapsed` | left: 72px |
| `.sidebar-submenu` | max-height: 0, transition |
| `.sidebar-submenu.open` | max-height: 500px |
| `.menu-arrow.rotated` | transform: rotate(90deg) |

### 5.2 Sidebar (`resources/views/layouts/sidebar.blade.php`)

**Menu Structure:**

| Parent | Submenu Items |
|--------|---------------|
| Dashboard *(direct link)* | — |
| Inventory *(toggle)* | Products, Categories, Brands, Stock, Warehouses, Stock Adjustments |
| Sales *(toggle)* | Orders, Invoices, Returns, Shipments |
| Purchases *(toggle)* | Purchase Orders, Suppliers |
| People *(toggle)* | Customers, Suppliers |
| Finance *(toggle)* | Expenses, Payments, Reports, Tax Rates |
| User Management *(toggle)* | Users, Roles |
| Activity Log *(direct link)* | — |
| Settings *(direct link)* | — |

**Active Route Pattern:**
- Parent toggle buttons have `data-active-route="{{ request()->routeIs('products') || ... ? '1' : '0' }}"` — auto-opens submenu on page load.
- Submenu `<a>` links have `{{ request()->routeIs('products') ? '!text-indigo-600 !bg-indigo-50' : '' }}` for active state.
- Direct links use `{{ request()->routeIs('dashboard') ? 'active' : '' }}` which maps to `.sidebar-link.active` in CSS.

### 5.3 Welcome/Login Page (`resources/views/welcome.blade.php`)

Standalone page (does NOT extend `panel.blade.php`). Includes:
- Inventrix branding
- Email + password login form
- Error/session status display
- Link to register (if route exists)
- Uses Vite assets directly

---

## 6. Routes

All routes in `routes/web.php`. No auth middleware — pages are freely accessible.

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\StockAdjustmentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaxRateController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;

Route::get('/', function () {
    return view('welcome');
})->name('login');

// Panel pages
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Inventory
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/brands', [BrandController::class, 'index'])->name('brands');
Route::get('/stock', [StockController::class, 'index'])->name('stock');
Route::get('/warehouses', [WarehouseController::class, 'index'])->name('warehouses');
Route::get('/stock-adjustments', [StockAdjustmentController::class, 'index'])->name('stock-adjustments');

// Sales
Route::get('/orders', [OrderController::class, 'index'])->name('orders');
Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices');
Route::get('/returns', [ReturnController::class, 'index'])->name('returns');
Route::get('/shipments', [ShipmentController::class, 'index'])->name('shipments');

// Purchases
Route::get('/purchase-orders', [PurchaseOrderController::class, 'index'])->name('purchase-orders');
Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers');

// People
Route::get('/customers', [CustomerController::class, 'index'])->name('customers');

// Finance
Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses');
Route::get('/payments', [PaymentController::class, 'index'])->name('payments');
Route::get('/reports', [ReportController::class, 'index'])->name('reports');
Route::get('/tax-rates', [TaxRateController::class, 'index'])->name('tax-rates');

// System
Route::get('/settings', [SettingController::class, 'index'])->name('settings');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::get('/users', [UserController::class, 'index'])->name('users');
Route::get('/roles', [RoleController::class, 'index'])->name('roles');
Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity-log');
```

---

## 7. Feature Pages (Build Order)

Build pages in this order for a logical progression.

### Phase 1: Foundation

| # | Page | File | What It Shows |
|---|------|------|---------------|
| 1 | **Login** | `welcome.blade.php` | Standalone login form with brand logo |
| 2 | **Layout** | `layouts/panel.blade.php` + `layouts/sidebar.blade.php` | Master layout with collapsible sidebar, topbar, content area |
| 3 | **Dashboard** | `dashboard.blade.php` | Stat cards (products, sales, orders, low stock), recent orders table, low stock alerts |

### Phase 2: Inventory

| # | Page | File | What It Shows |
|---|------|------|---------------|
| 4 | **Products** | `products.blade.php` | Search, filter dropdown (category/status/price), table (name/SKU/category/price/stock/status), pagination |
| 5 | **Categories** | `categories.blade.php` | Card grid with icon, name, product count, edit/delete |
| 6 | **Brands** | `brands.blade.php` | Table (name/description/website/status), pagination |
| 7 | **Stock** | `stock.blade.php` | Stat cards (total/in stock/low/out), table (product/SKU/warehouse/quantity bar/min stock/status) |
| 8 | **Warehouses** | `warehouses.blade.php` | Stat cards (total/capacity/occupied/available), cards with capacity bar/manager/status |
| 9 | **Stock Adjustments** | `stock-adjustments.blade.php` | Stat cards (total/additions/deductions/net), filter tabs (all/additions/deductions/transfers), table (reference/product/type/quantity/warehouse/reason/date) |

### Phase 3: Sales

| # | Page | File | What It Shows |
|---|------|------|---------------|
| 10 | **Orders** | `orders.blade.php` | Stat cards (total/pending/processing/revenue), filter tabs, table (checkbox/order#/customer/items/total/date/payment/status) |
| 11 | **Invoices** | `invoices.blade.php` | Stat cards (revenue/paid/pending/overdue), filter tabs, table (invoice#/customer/amount/issue/due/status) with overdue red border |
| 12 | **Returns** | `returns.blade.php` | Stat cards (total/pending/approved/refunded), filter tabs, table (return#/order/customer/items/amount/reason/status) |
| 13 | **Shipments** | `shipments.blade.php` | Stat cards (total/in-transit/delivered/delayed), filter tabs, table (tracking#/order/customer/carrier/origin/status) |

### Phase 4: Purchases

| # | Page | File | What It Shows |
|---|------|------|---------------|
| 14 | **Purchase Orders** | `purchase-orders.blade.php` | Stat cards (total/pending/approved/received), filter tabs, table (checkbox/PO#/supplier/items/total/date/delivery/status) |
| 15 | **Suppliers** | `suppliers.blade.php` | Stat cards (total/active/pending/inactive), table (company/contact/email/phone/products/status) |

### Phase 5: People

| # | Page | File | What It Shows |
|---|------|------|---------------|
| 16 | **Customers** | `customers.blade.php` | Stat cards (total/active/new/avg lifetime), table (name/email/phone/orders/spent/status) |

### Phase 6: Finance

| # | Page | File | What It Shows |
|---|------|------|---------------|
| 17 | **Expenses** | `expenses.blade.php` | Stat cards (total/month/pending/budget), filter tabs, table (description/category/amount/date/method/status) |
| 18 | **Payments** | `payments.blade.php` | Stat cards (total/incoming/outgoing/net cash flow), filter tabs, table (transaction#/payer-payee/type/amount/method/date/status) |
| 19 | **Reports** | `reports.blade.php` | Report type cards (Sales/Inventory/Financial), recent reports table, date range filter |
| 20 | **Tax Rates** | `tax-rates.blade.php` | Stat cards (active/standard/reduced/zero), table (name/rate/type/region/applies-to/status) |

### Phase 7: System

| # | Page | File | What It Shows |
|---|------|------|---------------|
| 21 | **Settings** | `settings.blade.php` | Left nav tabs (General/Payment/Inventory/Notifications/Security/Preferences), General form, Logo upload, Notification toggles |
| 22 | **Profile** | `profile.blade.php` | Left card (avatar/role/contact/activity feed), Personal info form, Change password, Profile picture upload |
| 23 | **Users** | `users.blade.php` | Stat cards (total/active/admins/pending), table (name/email/role/last login/status) |
| 24 | **Roles** | `roles.blade.php` | Role cards with permission grids (Administrator/Manager/Staff), checkmark/X for each permission |
| 25 | **Activity Log** | `activity-log.blade.php` | Filter tabs (all/inventory/sales/users/settings), table (time/user/action/module/description/IP) |

---

## 8. Blade View Reference

### 8.1 View Template Pattern

Every panel page follows this structure:

```blade
@extends('layouts.panel')

@section('title', 'Page Title - Inventrix')
@section('page-title', 'Page Title')

@section('content')
    <!-- Search / Filters / Action buttons -->
    <!-- Stat cards grid -->
    <!-- Main table or card grid -->
    <!-- Pagination footer -->
@endsection

@section('footer-scripts')
<script>
    // Page-specific JavaScript (filter dropdowns, etc.)
</script>
@endsection
```

### 8.2 Common Elements

**Stat Card Pattern:**
```blade
<div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
    <p class="text-sm text-gray-500">Label</p>
    <p class="text-2xl font-bold text-gray-900 mt-1">Value</p>
    <p class="text-xs text-green-600 mt-2">Change indicator</p>
</div>
```

**Table Pattern:**
```blade
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Column</th>
                    <!-- ... -->
                    <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($items as $item)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $item->field }}</td>
                    <!-- ... -->
                    <td class="px-6 py-4 text-right">
                        <!-- View / Edit / Delete buttons -->
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-500">No data found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100 bg-gray-50">
        <p class="text-sm text-gray-500">{{ $items->firstItem() }}-{{ $items->lastItem() }} of {{ $items->total() }} items</p>
        {{ $items->links() }}
    </div>
</div>
```

**Status Badge Pattern:**
```blade
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Active</span>
```

Color mapping:
- `bg-green-100 text-green-700` — Active, Completed, Paid, Delivered, In Stock
- `bg-yellow-100 text-yellow-700` — Pending, Low Stock, Processing
- `bg-blue-100 text-blue-700` — Processing, Approved, Shipped
- `bg-red-100 text-red-700` — Cancelled, Overdue, Out of Stock, Inactive
- `bg-amber-100 text-amber-700` — Maintenance, Draft

**Filter Buttons Pattern:**
```blade
<div class="flex items-center gap-3">
    <button class="px-4 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 shadow-sm transition-colors">All</button>
    <button class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 bg-white transition-colors">Filter</button>
</div>
```

**Pagination Pattern (Laravel links):**
```blade
<div class="flex items-center justify-between px-6 py-4 border-t border-gray-100 bg-gray-50">
    <p class="text-sm text-gray-500">Showing {{ $items->firstItem() }}-{{ $items->lastItem() }} of {{ $items->total() }}</p>
    <div class="flex items-center gap-2">
        {{ $items->links('vendor.pagination.tailwind') }}
    </div>
</div>
```

### 8.3 Sidebar Active Link Logic

```blade
<!-- Parent toggle with auto-open -->
<button class="sidebar-item ..." data-toggle="inventory"
    data-active-route="{{ request()->routeIs('products') || request()->routeIs('categories') || request()->routeIs('brands') || request()->routeIs('stock') || request()->routeIs('warehouses') || request()->routeIs('stock-adjustments') ? '1' : '0' }}">

<!-- Submenu child with active highlight -->
<a href="{{ route('products') }}" class="submenu-item ... {{ request()->routeIs('products') ? '!text-indigo-600 !bg-indigo-50' : '' }}">

<!-- Direct link with active highlight -->
<a href="{{ route('dashboard') }}" class="sidebar-item sidebar-link ... {{ request()->routeIs('dashboard') ? 'active' : '' }}">
```

---

## 9. Commands Quick Reference

```bash
# Create project
composer create-project laravel/laravel inventrix

# Install npm dependencies
npm install

# Development servers (run simultaneously)
npx vite dev            # Frontend hot-reload
php artisan serve       # Backend server

# Build for production
npx vite build

# Create model with migration
php artisan make:model Product -m

# Create migration only
php artisan make:migration create_products_table

# Create controller
php artisan make:controller ProductController

# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Fresh migrate (drop all tables and re-run)
php artisan migrate:fresh

# Create seeder
php artisan make:seeder ProductSeeder

# Run seeders
php artisan db:seed

# Create a full resource controller with model
php artisan make:controller ProductController --resource --model=Product

# List all routes
php artisan route:list

# Clear cache
php artisan optimize:clear

# Create service class (manual)
mkdir -p app/Services
# then create app/Services/StockService.php
```

---

## Architecture Summary

```
inventrix/
├── app/
│   ├── Http/
│   │   └── Controllers/       # Controller classes per module
│   ├── Models/                # Eloquent models
│   └── Services/              # Business logic services (optional)
├── database/
│   ├── migrations/            # Table definitions (build in dependency order)
│   └── seeders/               # Demo/test data seeders
├── resources/
│   ├── css/
│   │   └── app.css            # Tailwind v4 import + theme config
│   ├── js/
│   │   └── app.js             # Vite entry point
│   └── views/
│       ├── layouts/
│       │   ├── panel.blade.php    # Master layout (sidebar, topbar, content)
│       │   └── sidebar.blade.php  # Collapsible sidebar with all menus
│       ├── welcome.blade.php      # Login page (standalone)
│       ├── dashboard/
│       │   └── dashboard.blade.php
│       ├── inventory/
│       │   ├── products.blade.php
│       │   ├── categories.blade.php
│       │   ├── brands.blade.php
│       │   ├── stock.blade.php
│       │   ├── warehouses.blade.php
│       │   └── stock-adjustments.blade.php
│       ├── sales/
│       │   ├── orders.blade.php
│       │   ├── invoices.blade.php
│       │   ├── returns.blade.php
│       │   └── shipments.blade.php
│       ├── purchases/
│       │   ├── purchase-orders.blade.php
│       │   └── suppliers.blade.php
│       ├── people/
│       │   └── customers.blade.php
│       ├── finance/
│       │   ├── expenses.blade.php
│       │   ├── payments.blade.php
│       │   ├── reports.blade.php
│       │   └── tax-rates.blade.php
│       └── system/
│           ├── settings.blade.php
│           ├── profile.blade.php
│           ├── users.blade.php
│           ├── roles.blade.php
│           └── activity-log.blade.php
├── routes/
│   └── web.php                # All panel routes
├── vite.config.js             # Vite + Laravel + Tailwind v4
├── package.json               # Frontend dependencies
└── composer.json              # Backend dependencies
```

---

**Migration Build Order** (respect foreign key dependencies):

1. `create_users_table.php`
2. `create_categories_table.php`
3. `create_brands_table.php`
4. `create_warehouses_table.php`
5. `create_products_table.php`
6. `create_stock_items_table.php`
7. `create_customers_table.php`
8. `create_suppliers_table.php`
9. `create_orders_table.php`
10. `create_order_items_table.php`
11. `create_invoices_table.php`
12. `create_purchase_orders_table.php`
13. `create_purchase_order_items_table.php`
14. `create_returns_table.php`
15. `create_shipments_table.php`
16. `create_stock_adjustments_table.php`
17. `create_expenses_table.php`
18. `create_transactions_table.php`
19. `create_tax_rates_table.php`
20. `create_activity_log_table.php`
21. `create_roles_table.php` (optional)
22. `create_role_permissions_table.php` (optional)
