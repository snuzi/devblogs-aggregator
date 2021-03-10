# engineering-blogs-aggregator
Engineering blogs aggregator

## Contribute
1. Add tech engineering blogs [awesome-tech-blogs](https://github.com/snuzi/awesome-tech-blogs)

2. Frontend application [engineering-blogs-app](https://github.com/snuzi/engineering-blogs-app)

3. Blog aggregator [engineering-blogs-aggregator](https://github.com/snuzi/engineering-blogs-aggregator)


## Development

Copy `.env.example` to `.env`

### Run MeiliSearch
```
$ docker run -it --rm -p 7700:7700 --network=engineering-blogs --name eng-blogs-meili -v data.ms:/data.ms getmeili/meilisearch
```

### Run image
`docker-compose up`

### Run a commands inside the aggregator container
`docker exec -it eng-blogs-aggregator bash`

#### Create index
`php src/bin/app db:create-index`

#### Update index settings
`php src/bin/app db:update-index-settings`

#### Crawl rss feeds
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
