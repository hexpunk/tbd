#!/bin/sh

MY_PATH=$(dirname "$0")
APP_PATH="$MY_PATH/../"
IMAGE_NAME="tbd-dev-env"
CONTAINER_NAME=$IMAGE_NAME

if ! podman images --format "{{.Repository}}" | grep -q $IMAGE_NAME; then
  podman build --squash-all -t $IMAGE_NAME -f "$MY_PATH/Dockerfile"
fi

if podman ps --format "{{.Names}}" | grep -q $CONTAINER_NAME; then
  podman exec -it $CONTAINER_NAME /bin/sh
else
  podman run -it --rm \
    --name $CONTAINER_NAME \
    -p "127.0.0.1:3000:3000/tcp" \
    -v "$APP_PATH:/root/app/" \
    $IMAGE_NAME
fi
