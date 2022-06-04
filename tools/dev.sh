#!/bin/sh

APP_PATH="$(dirname "$0")/../"

podman run -it --rm \
  --entrypoint "/bin/bash" \
  -p "8000:8000" \
  -p "35729:35729" \
  -v "$APP_PATH:/root/app/" \
  -w "/root/app" \
  node:18
