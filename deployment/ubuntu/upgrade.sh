#!/bin/bash

function upgrade_caterpillar {
    echo "Upgrade caterpillar ..."

    cd /etc/caterpillar
    mv config.prod.yml config.back.yml

    LATEST_VERSION=$(curl --silent "https://api.github.com/repos/Clivern/caterpillar/releases/latest" | jq '.tag_name' | sed -E 's/.*"([^"]+)".*/\1/' | tr -d v)

    curl -sL https://github.com/Clivern/caterpillar/releases/download/v{$LATEST_VERSION}/caterpillar_{$LATEST_VERSION}_Linux_x86_64.tar.gz | tar xz

    rm config.prod.yml
    mv config.back.yml config.prod.yml

    systemctl restart caterpillar

    echo "Caterpillar upgrade done!"
}

upgrade_caterpillar
