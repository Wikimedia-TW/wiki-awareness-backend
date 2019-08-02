*version 0.1.0*
## How To Start Service
##### Installation
1. Install Docker
2. Prepare config file & set-up credentials
```bash
mv .env.example .env
```
3. You are good to go.
##### Starting Service
```bash
docker-compose up -d
```
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
| url | string \| required | 255 |
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
