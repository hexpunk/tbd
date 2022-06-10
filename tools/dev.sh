#!/bin/sh

APP_PATH="$(dirname "$0")/../"

podman run -it --rm \
  --entrypoint "/bin/bash" \
  -p "127.0.0.1:8000:8000/tcp" \
  -p "127.0.0.1:35729:35729/tcp" \
  -v "$APP_PATH:/root/app/" \
  -w "/root/app" \
  node:18
