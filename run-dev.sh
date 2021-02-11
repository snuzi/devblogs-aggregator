projectName="eng-blogs-aggregator"

if [ "$1" = "build" ]; then
    echo "Building  $projectName"
    docker build -t ${projectName} -f Dockerfile .
fi


echo "Running $projectName container"
existingContainer="$(docker ps --all --quiet --filter=name="$projectName")"
if [ -n "$existingContainer" ]; then
docker stop $existingContainer && docker rm $existingContainer
echo "Stopped container $projectName "
fi

echo "Starting container $projectName "

docker run -d \
--env-file ${PWD}/.env \
--volume ${PWD}/src/:/var/eng-blogs \
--name ${projectName} \
${projectName}