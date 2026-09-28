# Laravel Product CRUD API

A beginner-friendly Laravel API boilerplate for a separate React frontend.

## What this provides

- JSON API at `/api/products`
- Product **create, read, update, and delete** operations
- Request validation
- CORS for the Vite React server
- One-minute cache for the product-list endpoint
- Cache is cleared immediately after creating, updating, or deleting a product

## First-time setup

1. Run `composer install`.
2. Copy `.env.example` to `.env`.
3. Set your database values in `.env`. The starter uses SQLite by default, but MySQL also works.
4. Run `php artisan key:generate`.
5. Run `php artisan migrate`.
6. Run `php artisan serve`.

The API will be available at `http://127.0.0.1:8000/api`.

## Product endpoints

| Method | URL | Purpose |
| --- | --- | --- |
| GET | `/api/products` | List products (cached for one minute) |
| POST | `/api/products` | Create a product |
| GET | `/api/products/{id}` | Get one product |
| PUT | `/api/products/{id}` | Update a product |
| DELETE | `/api/products/{id}` | Delete a product |

### Create or update request body

```json
{
  "name": "Notebook",
  "description": "A5 ruled notebook",
  "price": 45.50,
  "quantity": 10
}
```

## Where to modify things

- `app/Models/Product.php` — allowed Product fields
- `database/migrations/...create_products_table.php` — database columns
- `app/Http/Controllers/Api/ProductController.php` — API, validation, and cache logic
- `routes/api.php` — API URLs
- `config/cors.php` — frontend URLs allowed to call the API

## Cache

This boilerplate uses Laravel's **file cache**, so no separate cache database table is required. `GET /api/products` is stored for one minute. Product writes remove that stored list immediately, so a subsequent read gets fresh data.
