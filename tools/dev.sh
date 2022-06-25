#!/bin/sh

APP_PATH="$(dirname "$0")/../"
CONTAINER_NAME="tbd-dev"
ENTRYPOINT="/bin/bash"

if podman ps --format "{{.Names}}" | grep -q $CONTAINER_NAME; then
  podman exec -it $CONTAINER_NAME $ENTRYPOINT
else
 podman run -it --rm \
  --entrypoint $ENTRYPOINT \
  --name $CONTAINER_NAME \
  -p "127.0.0.1:3000:3000/tcp" \
  -v "$APP_PATH:/root/app/" \
  -w "/root/app" \
  node:18
fi
