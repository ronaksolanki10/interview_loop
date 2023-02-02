
# LOOP New Media GmbH Assessment

A project is about to build a Backend for the simple mini webshop (Ecommerce)

## Author

- [@ronaksolanki10](https://github.com/ronaksolanki10)


## Tech Stack

**Programming Language:** PHP

**Framework:** Laravel 9.19 (A PHP Framework for Web Artisan)

**Databse:** MySql


## Installation

Below is the steps to install the project

1. Clone the project
```bash
  git clone https://github.com/ronaksolanki10/interview_loop.git
```
2. Install dependencies

```bash
  composer install
```
3. Copy ```.env.example``` to ```.env```

4. Set database credentials accordingly in ```.env``` file

5. Add database tables using below command

```bash
  php artisan migrate
```

6. Execute below commands to store Customers & Products MasterData from the mentioned CSV URL

```bash
  php artisan import:customers
  php artisan import:products
```
7. Generate the application key & clear the cache

```bash
  php artisan key:generate
  php artisan optimize:clear
```

8. Start laravel application if testing in local machine using below command and the URL will be used as ```Base URL``` for the APIs, if setupping on the server then use URL accordingly.

```
 php artisan serve

```


    
## API Reference

Note: Below headers are required to make successfull API request

```
  Content-Type: application/json
  Accept: application/json
```
#### 1. List of orders with filter

```http
  POST api/orders/list
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `page`      | `integer` | **Required**. Which page to return |
| `rowsPerPage`      | `integer` | **Required**. Records per page |
| `sortBy`      | `string` | **Required**. Order the records with selected column |
| `sortType`      | `string` | **Required**. Direction of the order |
| `search[customer_id]`      | `integer` | **Optional**. Filter records matching specified customer |
| `search[payed]`      | `boolean` | **Optional**. Filter records matching whether order is payed or not |

#### 2. Create a new order

```http
  POST api/orders
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `customer_id`      | `integer` | **Required**. ID of the customer |

#### 3. Get a order details

```http
  GET /api/orders/{id}
```
```{id}``` - ID of an order

#### 4. Attach Product

```http
  POST api/orders/{id}/add
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `product_id`      | `integer` | **Required**. ID of the product |

#### 5. Remove Product fron an order (De-Attach)

```http
  POST api/orders/{id}/remove
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `product_id`      | `integer` | **Required**. ID of the product |

#### 6. Pay for an order

```http
  POST api/orders/{id}/pay
```
```{id}``` - ID of an order


#### 7. Delete an order

```http
  DELETE /api/orders/{id}
```
```{id}``` - ID of an order
## Estimated and tracked time

| Task | Estimated Time (Hours) | Tracked Time (Hours)                       |
| :-------- | :------- | :-------------------------------- |
| Project Setup      | 2 | 1.5 |
| Database Design      | 1 | 1 |
| Architecture      | 4 | 4 |
| Order CRUD APIs      | 2 | 3 |
| Attach/De-attach Product API      | 2 | 1.5 |
| Pay for an Order API      | 1 | 1 |

## Feedback

If you have any feedback or query, please feel free to reach out to me at ronaksolanki1310@gmail.com

