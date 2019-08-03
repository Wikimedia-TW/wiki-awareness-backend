*version 0.1.0*
## How To Start Service
##### Installation
1. Install Docker
2. git clone
3. docker run --rm -v $(pwd):/app composer install
4. sudo chown -R $USER:$USER ~/laravel-app
5. Config .env and set up GCP project credential file
```bash
mv .env.example .env
```
##### Starting Service
```bash
docker-compose up -d
```
```bash
docker-compose exec app php artisan migrate:install
```
> Note. Only need to be executed at the first time.
```bash
docker-compose exec app php artisan migrate
```
> Note. Only need to be executed once for every version.

##### Ending Service
```bash
docker-compose down
```

## Task Lists
- [x] Creating a report
- [x] Connecting reports to Google sheets

## APIs Description
### Reports

#### 1. Creating a new report
```
POST localhost/api/reports
```
| key | validation |
| --- | --- |
| fingerprint | string \| required \| 255 |
| url | string \| required \| 255 |
| highlighted | string \| required \| 255 |
| description | string \| 255 |
| type | string \| required \| 12 |
###### Response Example
```
Status 201
```
#### 2. Getting all reports(for test)

```
GET localhost/api/reports
```
