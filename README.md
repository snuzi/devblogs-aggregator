#  Developer Blogs Aggregator
This project is the aggregator of [devblogs.net](https://github.com/snuzi/devblogs)

## Contribute
1. Add your dev blog [awesome-dev-blogs](https://github.com/snuzi/awesome-dev-blogs)

2. Frontend application [devblogs.net](https://github.com/snuzi/devblogs)

3. Blog aggregator [devblogs-aggregator](https://github.com/snuzi/devblogs-aggregator)


## Development

Copy `.env.example` to `.env`


### Run
`docker-compose up`


### Run a commands inside the aggregator container
`docker exec -it eng-blogs-aggregator bash`

#### Update index settings
This will create the index if not exists

`php src/bin/app db:update-index-settings`

#### Crawl RSS feeds
`php src/bin/app rss:crawl`

## Production
1. Create **.env** and set correct production environment variables:
`cp .env.example .env`

2. Run docker image:

```
docker run -d --env-file ./.env  --name blogs-aggregator snuzi/engineering-blogs-aggregator:main
```
3. Update index settings after deployment 
```
docker exec -d blogs-aggregator php src/bin/app db:update-index-settings
```
