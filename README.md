# engineering-blogs-aggregator
Engineering blogs aggregator

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

