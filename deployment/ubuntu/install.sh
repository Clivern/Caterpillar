#!/bin/bash

function install_dependencies {
    echo "Installing dependencies ..."

    apt-get update

    apt-get upgrade -y

    apt-get install jq bind9 -y

    echo "Installing dependencies done!"
}

function install_etcd {
    echo "Installing etcd ..."

    ETCD_VER=v3.5.4

    GOOGLE_URL=https://storage.googleapis.com/etcd
    GITHUB_URL=https://github.com/etcd-io/etcd/releases/download
    DOWNLOAD_URL=${GOOGLE_URL}

    rm -f /tmp/etcd-${ETCD_VER}-linux-amd64.tar.gz
    rm -rf /tmp/etcd-download-test && mkdir -p /tmp/etcd-download-test

    curl -L ${DOWNLOAD_URL}/${ETCD_VER}/etcd-${ETCD_VER}-linux-amd64.tar.gz -o /tmp/etcd-${ETCD_VER}-linux-amd64.tar.gz
    tar xzvf /tmp/etcd-${ETCD_VER}-linux-amd64.tar.gz -C /tmp/etcd-download-test --strip-components=1
    rm -f /tmp/etcd-${ETCD_VER}-linux-amd64.tar.gz

    /tmp/etcd-download-test/etcd --version
    /tmp/etcd-download-test/etcdctl version

    cp /tmp/etcd-download-test/etcd /usr/local/bin/
    cp /tmp/etcd-download-test/etcdctl /usr/local/bin/

    mkdir -p /var/lib/etcd/
    mkdir /etc/etcd

    groupadd --system etcd
    useradd -s /sbin/nologin --system -g etcd etcd

    chown -R etcd:etcd /var/lib/etcd/

    echo "[Unit]
Description=Etcd KV Store
Documentation=https://github.com/etcd-io/etcd
After=network.target

[Service]
User=etcd
Type=notify
Environment=ETCD_DATA_DIR=/var/lib/etcd
Environment=ETCD_NAME=%m
ExecStart=/usr/local/bin/etcd --listen-client-urls http://127.0.0.1:2379 --advertise-client-urls http://127.0.0.1:2379
Restart=always
RestartSec=10s
LimitNOFILE=40000

[Install]
WantedBy=multi-user.target" > /etc/systemd/system/etcd.service

    systemctl daemon-reload
    systemctl enable etcd.service
    systemctl start etcd.service

    echo "etcd installation done!"
}

function install_caterpillar {
    echo "Installing caterpillar ..."

    mkdir -p /etc/caterpillar

    cd /etc/caterpillar

    LATEST_VERSION=$(curl --silent "https://api.github.com/repos/Clivern/caterpillar/releases/latest" | jq '.tag_name' | sed -E 's/.*"([^"]+)".*/\1/' | tr -d v)

    curl -sL https://github.com/Clivern/caterpillar/releases/download/v{$LATEST_VERSION}/caterpillar_{$LATEST_VERSION}_Linux_x86_64.tar.gz | tar xz


    echo "[Unit]
Description=Caterpillar
Documentation=https://github.com/Clivern/caterpillar

[Service]
ExecStart=/etc/caterpillar/caterpillar server -c /etc/caterpillar/config.prod.yml
Restart=on-failure
RestartSec=2

[Install]
WantedBy=multi-user.target" > /etc/systemd/system/caterpillar.service

    systemctl daemon-reload
    systemctl enable caterpillar.service
    systemctl start caterpillar.service

    echo "Caterpillar installation done!"
}

install_dependencies
install_etcd
install_caterpillar
