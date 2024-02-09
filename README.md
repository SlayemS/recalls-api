# recalls-api

### Description
API for car recalls developed using PHP Slim framework and JWT Authentication

### API Features and Practices

- Error Handling
- Inputs & Data Validation
- Filtering, Paging, and Sorting on Exposed Collection Resources
- Content Negotiation Handling
- Root Resource
- Logging
- Versioning

### Database
This API uses a MySQL database to store information about manufacturers, models, cars, recalls, repairs, customers, and instances. The design ensures efficient data retrieval and storage, supporting complex queries with optimized indexing.

Database Schema:
![dbrecalls](https://github.com/SlayemS/recalls-api/assets/83617577/708fe559-f64c-4f61-945f-fde13166a565)

### Exception Handling
The API implements comprehensive exception handling to ensure reliability and ease of debugging. Valid HTTP status codes are returned to indicate the outcome of requests:
- `200 OK` - The request has succeeded.
- `201 Created` - A new resource has been created successfully.
- `400 Bad Request` - The request cannot be processed due to bad request syntax, invalid request message parameters, or deceptive request routing.
- `404 Not Found` - The requested resource was not found.
- `418 I'm a Teapot`
- `500 Internal Server Error` - The server encountered an unexpected condition that prevented it from fulfilling the request.

### Exposed Resources
Here is the following list of exposed resources and their filters:

| Method | Route                                       | Description                                      | Filters                                             |
|--------|---------------------------------------------|--------------------------------------------------|-----------------------------------------------------|
| GET    | `/manufacturers`                            | Retrieve all manufacturers                       | year, vehicle_type, fuel_type, transmission_type, engine, power_type |
| POST   | `/manufacturers`                            | Create a manufacturer                            |                                                     |
| PUT    | `/manufacturers`                            | Update a manufacturer                            |                                                     |
| GET    | `/manufacturers/{manufacturer_id}/models`   | Retrieve models by manufacturer ID               |                                                     |
| DELETE | `/manufacturers/{manufacturer_id}`          | Delete a manufacturer                            |                                                     |
| GET    | `/models`                                   | Retrieve all models                              | year, vehicle_type, fuel_type, transmission_type, engine, power_type |
| POST   | `/models`                                   | Create a model                                   |                                                     |
| PUT    | `/models`                                   | Update a model                                   |                                                     |
| GET    | `/models/{model_id}/cars`                   | Retrieve cars by model ID                        |                                                     |
| GET    | `/models/{model_id}/recalls`                | Retrieve recalls by model ID                     |                                                     |
| DELETE | `/models`                                   | Delete a model                                   |                                                     |
| GET    | `/repairs`                                  | Retrieve all repairs                             | status, max_cost, min_cost                          |
| POST   | `/repairs`                                  | Create a repair                                  |                                                     |
| PUT    | `/repairs`                                  | Update a repair                                  |                                                     |
| DELETE | `/repairs/{repair_id}`                      | Delete a repair by ID                            |                                                     |
| GET    | `/recalls`                                  | Retrieve all recalls                             | subject, issue_date, component                      |
| GET    | `/recalls/{recall_id}/instance`             | Retrieve instance by recall ID                   |                                                     |
| POST   | `/recalls`                                  | Create a recall                                  |                                                     |
| PUT    | `/recalls`                                  | Update a recall                                  |                                                     |
| GET    | `/customers`                                | Retrieve all customers                           | first_name, last_name, customer_id                  |
| GET    | `/customers/{customer_id}/cars`             | Retrieve cars by customer ID                     |                                                     |
| DELETE | `/customers/{customer_id}`                  | Delete a customer                                |                                                     |
| GET    | `/cars`                                     | Retrieve all cars                                | dealership, color, max_mileage, min_mileage, customer_id |
| GET    | `/cars/{car_id}/instances`                  | Retrieve instances by car ID                     |                                                     |
| POST   | `/cars`                                     | Create a car                                     |                                                     |
| PUT    | `/cars`                                     | Update a car                                     |                                                     |
| DELETE | `/cars/{car_id}`                            | Delete a car by ID                               |                                                     |
| GET    | `/instances`                                | Retrieve all instances                           | job_done                                             |
| GET    | `/instances/{instance_id}/repairs`          | Retrieve repairs by instance ID                  |                                                     |
| POST   | `/instances`                                | Create an instance                               |                                                     |
| PUT    | `/instances`                                | Update an instance                               |                                                     |
| DELETE | `/instances/{instance_id}`                  | Delete an instance by ID                         |                                                     |
| POST   | `/account`                                  | Create an account                                |                                                     |
| POST   | `/token`                                    | Generate a token                                 |                                                     |

### More Information
For more information about our journey, refer to the project associated with this repository in the `Projects` tab.
