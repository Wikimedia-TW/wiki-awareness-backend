*version 0.1.0*
## How To Start Service
##### Installation
1. [Install Docker](https://docs.docker.com/install/)
2. Clone repository
```bash
git clone git@github.com:Wikimedia-TW/wiki-awareness-backend.git
```
3. Install required packages
```bash
cd wiki-awareness-backend
docker run --rm -v $(pwd):/app composer install
```
4. Change file owner to current user
```bash
sudo chown -R $USER:$USER ~/wiki-awareness-backend
```
5. Config .env and set up GCP project credential file
```bash
mv .env.example .env
mkdir service
mv g0v-wiki-awareness-e81bff7c6201.json ~/wiki-awareness-backend/service/.
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
#### 2. Getting all reports(disabled)

```
GET localhost/api/reports
```
