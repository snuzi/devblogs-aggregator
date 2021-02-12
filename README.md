# engineering-blogs-aggregator
Engineering blogs aggregator

## Development

Copy `.env.example` to `.env`

### Run MeiliSearch
```
$ docker run -it --rm -p 7700:7700 -v $(pwd)/data.ms:/data.ms getmeili/meilisearch
```

### Build image
`./run-dev.sh build`

### Run image
`./run-dev.sh`

### Run a command
`php bin/app rss:crawl`
