# Store Order & Inventory Mini-System

A Laravel-based store billing and inventory management system developed as part of the Laravel Developer mini-task.

## Features

- Product and customer management using Laravel models, factories and seeders.
- Product listing API.
- Order creation API with customer details and multiple product items.
- Automatic subtotal, tax and grand total calculations.
- Stock validation and deduction during order creation.
- Database transactions and row locking for safer stock updates.
- Customer order history API using email.
- Configurable low-stock product API.
- Queue job that simulates an order confirmation email and records it in the Laravel log.
- Billing interface with product selection, payment calculations, balance to return and low-stock alerts.
- Automated tests for order creation and insufficient stock.

## Requirements

- PHP 8.2 or compatible version
- Composer
- MySQL
- Laravel 12

## Installation

1. Clone the repository.
2. Install dependencies:

   ```bash
   composer install
   ```

3. Create a `.env` file:

   ```bash
   copy .env.example .env
   ```

4. Generate the application key:

   ```bash
   php artisan key:generate
   ```

5. Configure the database credentials in `.env`.
6. Configure the database queue:

   ```env
   QUEUE_CONNECTION=database
   ```

7. Run migrations and seed sample data:

   ```bash
   php artisan migrate --seed
   ```

8. Start the application:

   ```bash
   php artisan serve
   ```

9. In another terminal, start the queue worker:

   ```bash
   php artisan queue:work
   ```

## API Endpoints

| Method | Endpoint | Purpose |
|---|---|---|
| GET | `/api/products` | List products |
| GET | `/api/products/low-stock?threshold=10` | List products below the stock threshold |
| POST | `/api/orders` | Create an order |
| GET | `/api/orders/history?email=customer@example.com` | Retrieve a customer's order history |

### Create Order Request

Send JSON to `POST /api/orders`:

```json
{
  "customer": {
    "name": "Sample Customer",
    "email": "customer@example.com"
  },
  "items": [
    {
      "product_id": 1,
      "quantity": 2
    }
  ]
}
```

The API validates stock, calculates totals, creates the order and deducts stock within a database transaction.

## Billing Interface

Open `/billing` after starting the Laravel development server.

## Queue Job

`SendOrderConfirmationJob` simulates an order confirmation email. It writes order and customer details to `storage/logs/laravel.log`; it does not send an actual email.

## Tests

Run the automated test suite:

```bash
php artisan test
```

The current test suite verifies order creation, totals, stock deduction, insufficient-stock rejection and queue dispatch.

## Notes

- Configure your local database before running migrations and seeders.
- Keep `.env` and other secrets out of version control.
- Queue processing requires a running worker when using the database queue.
