### Init

```sh
apt-get update
apt-get upgrade -y
reboot
```

For Worker Nodes

```sh

```

For Controller (Master) Nodes Nodes

```sh

```


### Install docker (Runtime)

```sh
apt-get -y install make build-essential docker.io
systemctl enable docker
```

### Install Go

```sh
cd /tmp
wget https://dl.google.com/go/go1.18.1.linux-amd64.tar.gz
sudo tar -xvf go1.18.1.linux-amd64.tar.gz
rm -rf /usr/local/go
sudo mv go /usr/local
export GOROOT=/usr/local/go
export GOPATH=$HOME/go
export PATH=$PATH:$GOPATH/bin:$GOROOT/bin
```

### Build k8s

```sh
rm -rf $(go env GOPATH)/src/k8s.io/kubernetes
mkdir -p $(go env GOPATH)/src/k8s.io/
cd $(go env GOPATH)/src/k8s.io/
git clone -b v1.25.0-alpha.2 --depth 1 https://github.com/kubernetes/kubernetes.git
# My custom release
export KUBE_GIT_VERSION=v1.25.0-alpha.2
cd $(go env GOPATH)/src/k8s.io/kubernetes
make
```

### Download binaries

From here https://www.downloadkubernetes.com/

```sh
cd /tmp

wget https://dl.k8s.io/v1.24.2/bin/linux/amd64/kube-apiserver
wget https://dl.k8s.io/v1.24.2/bin/linux/amd64/kube-controller-manager
wget https://dl.k8s.io/v1.24.2/bin/linux/amd64/kube-scheduler
wget https://dl.k8s.io/v1.24.2/bin/linux/amd64/kubectl
wget https://dl.k8s.io/v1.24.2/bin/linux/amd64/kubelet
wget https://dl.k8s.io/v1.24.2/bin/linux/amd64/kube-proxy

curl -L  https://github.com/etcd-io/etcd/releases/download/v3.5.4/etcd-v3.5.4-linux-amd64.tar.gz -o etcd-v3.5.4-linux-amd64.tar.gz
tar xzvf etcd-v3.5.4-linux-amd64.tar.gz

wget https://github.com/cloudflare/cfssl/releases/download/v1.6.1/cfssljson_1.6.1_linux_amd64
wget https://github.com/cloudflare/cfssl/releases/download/v1.6.1/cfssl_1.6.1_linux_amd64

mv kube-apiserver /usr/local/bin/
mv kube-controller-manager /usr/local/bin/
mv kube-scheduler /usr/local/bin/
mv kubectl /usr/local/bin/
mv kube-proxy /usr/local/bin/
mv kubelet /usr/local/bin/
mv etcd-v3.5.4-linux-amd64/etcd /usr/local/bin/
mv etcd-v3.5.4-linux-amd64/etcdctl /usr/local/bin/
mv etcd-v3.5.4-linux-amd64/etcdutl /usr/local/bin/
mv cfssljson_1.6.1_linux_amd64 /usr/local/bin/cfssljson
mv cfssl_1.6.1_linux_amd64 /usr/local/bin/cfssl

rm -rf etcd-v3.5.4-linux-amd64.tar.gz
rm -rf etcd-v3.5.4-linux-amd64

chmod +x /usr/local/bin/kube-apiserver
chmod +x /usr/local/bin/kube-controller-manager
chmod +x /usr/local/bin/kube-scheduler
chmod +x /usr/local/bin/kubectl
chmod +x /usr/local/bin/etcd
chmod +x /usr/local/bin/etcdctl
chmod +x /usr/local/bin/etcdutl
chmod +x /usr/local/bin/kubelet
chmod +x /usr/local/bin/kube-proxy
chmod +x /usr/local/bin/cfssljson
chmod +x /usr/local/bin/cfssl
```


### Build Certifcates and Cluster Configs

Certificate Authority

```sh
$ mkdir -p /etc/kubernetes/configs
$ cd /etc/kubernetes/configs
```

```sh
$ cat > ca-config.json <<EOF
{
  "signing": {
    "default": {
      "expiry": "8760h"
    },
    "profiles": {
      "kubernetes": {
        "usages": ["signing", "key encipherment", "server auth", "client auth"],
        "expiry": "8760h"
      }
    }
  }
}
EOF

$ cat > ca-csr.json <<EOF
{
  "CN": "Kubernetes",
  "key": {
    "algo": "rsa",
    "size": 2048
  },
  "names": [
    {
      "C": "US",
      "L": "Portland",
      "O": "Kubernetes",
      "OU": "CA",
      "ST": "Oregon"
    }
  ]
}
EOF

$ cfssl gencert -initca ca-csr.json | cfssljson -bare ca

$ ls
ca-key.pem
ca.pem
```

Admin Client Certificate

```sh
$ cat > admin-csr.json <<EOF
{
  "CN": "admin",
  "key": {
    "algo": "rsa",
    "size": 2048
  },
  "names": [
    {
      "C": "US",
      "L": "Portland",
      "O": "system:masters",
      "OU": "Kubernetes The Hard Way",
      "ST": "Oregon"
    }
  ]
}
EOF

$ cfssl gencert \
  -ca=ca.pem \
  -ca-key=ca-key.pem \
  -config=ca-config.json \
  -profile=kubernetes \
  admin-csr.json | cfssljson -bare admin

$ ls
admin-key.pem
admin.pem
```

Kubelet Client Certificates

```sh
$ cat > worker01-csr.json <<EOF
{
  "CN": "system:node:worker01",
  "key": {
    "algo": "rsa",
    "size": 2048
  },
  "names": [
    {
      "C": "US",
      "L": "Portland",
      "O": "system:nodes",
      "OU": "Kubernetes The Hard Way",
      "ST": "Oregon"
    }
  ]
}
EOF

$ EXTERNAL_IP=188.166.54.88

$ INTERNAL_IP=10.133.0.2

$ cfssl gencert \
  -ca=ca.pem \
  -ca-key=ca-key.pem \
  -config=ca-config.json \
  -hostname=worker01,${EXTERNAL_IP},${INTERNAL_IP} \
  -profile=kubernetes \
  worker01-csr.json | cfssljson -bare worker01

$ ls
worker01.pem
worker01-key.pem
```

Controller Manager Client Certificate

```sh
$ cat > kube-controller-manager-csr.json <<EOF
{
  "CN": "system:kube-controller-manager",
  "key": {
    "algo": "rsa",
    "size": 2048
  },
  "names": [
    {
      "C": "US",
      "L": "Portland",
      "O": "system:kube-controller-manager",
      "OU": "Kubernetes The Hard Way",
      "ST": "Oregon"
    }
  ]
}
EOF

$ cfssl gencert \
  -ca=ca.pem \
  -ca-key=ca-key.pem \
  -config=ca-config.json \
  -profile=kubernetes \
  kube-controller-manager-csr.json | cfssljson -bare kube-controller-manager

$ ls
kube-controller-manager-key.pem
kube-controller-manager.pem
```

Kube Proxy Client Certificate

```sh
$ cat > kube-proxy-csr.json <<EOF
{
  "CN": "system:kube-proxy",
  "key": {
    "algo": "rsa",
    "size": 2048
  },
  "names": [
    {
      "C": "US",
      "L": "Portland",
      "O": "system:node-proxier",
      "OU": "Kubernetes The Hard Way",
      "ST": "Oregon"
    }
  ]
}
EOF

$ cfssl gencert \
  -ca=ca.pem \
  -ca-key=ca-key.pem \
  -config=ca-config.json \
  -profile=kubernetes \
  kube-proxy-csr.json | cfssljson -bare kube-proxy

$ ls
kube-proxy-key.pem
kube-proxy.pem
```

Scheduler Client Certificate

```sh
$ cat > kube-scheduler-csr.json <<EOF
{
  "CN": "system:kube-scheduler",
  "key": {
    "algo": "rsa",
    "size": 2048
  },
  "names": [
    {
      "C": "US",
      "L": "Portland",
      "O": "system:kube-scheduler",
      "OU": "Kubernetes The Hard Way",
      "ST": "Oregon"
    }
  ]
}
EOF

$ cfssl gencert \
  -ca=ca.pem \
  -ca-key=ca-key.pem \
  -config=ca-config.json \
  -profile=kubernetes \
  kube-scheduler-csr.json | cfssljson -bare kube-scheduler

$ ls
kube-scheduler-key.pem
kube-scheduler.pem
```

Kubernetes API Server Certificate

```sh
$ KUBERNETES_PUBLIC_ADDRESS=188.166.83.204

$ KUBERNETES_HOSTNAMES=kubernetes,kubernetes.default,kubernetes.default.svc,kubernetes.default.svc.cluster,kubernetes.svc.cluster.local

$ cat > kubernetes-csr.json <<EOF
{
  "CN": "kubernetes",
  "key": {
    "algo": "rsa",
    "size": 2048
  },
  "names": [
    {
      "C": "US",
      "L": "Portland",
      "O": "Kubernetes",
      "OU": "Kubernetes The Hard Way",
      "ST": "Oregon"
    }
  ]
}
EOF

$ cfssl gencert \
  -ca=ca.pem \
  -ca-key=ca-key.pem \
  -config=ca-config.json \
  -hostname=10.32.0.1,10.240.0.10,10.240.0.11,10.240.0.12,${KUBERNETES_PUBLIC_ADDRESS},127.0.0.1,${KUBERNETES_HOSTNAMES} \
  -profile=kubernetes \
  kubernetes-csr.json | cfssljson -bare kubernetes

$ ls
kubernetes-key.pem
kubernetes.pem
```

Service Account Key Pair

```sh
$ cat > service-account-csr.json <<EOF
{
  "CN": "service-accounts",
  "key": {
    "algo": "rsa",
    "size": 2048
  },
  "names": [
    {
      "C": "US",
      "L": "Portland",
      "O": "Kubernetes",
      "OU": "Kubernetes The Hard Way",
      "ST": "Oregon"
    }
  ]
}
EOF

$ cfssl gencert \
  -ca=ca.pem \
  -ca-key=ca-key.pem \
  -config=ca-config.json \
  -profile=kubernetes \
  service-account-csr.json | cfssljson -bare service-account

$ ls
service-account-key.pem
service-account.pem
```

`Kubelet` Kubernetes Configuration File

```sh
$ KUBERNETES_PUBLIC_ADDRESS=188.166.83.204

$ kubectl config set-cluster kubernetes-the-hard-way \
--certificate-authority=ca.pem \
--embed-certs=true \
--server=https://${KUBERNETES_PUBLIC_ADDRESS}:6443 \
--kubeconfig=worker01.kubeconfig

$ kubectl config set-credentials system:node:worker01 \
--client-certificate=worker01.pem \
--client-key=worker01-key.pem \
--embed-certs=true \
--kubeconfig=worker01.kubeconfig

$ kubectl config set-context default \
--cluster=kubernetes-the-hard-way \
--user=system:node:worker01 \
--kubeconfig=worker01.kubeconfig

$ kubectl config use-context default --kubeconfig=worker01.kubeconfig

$ ls
worker01.kubeconfig
```

`kube-proxy` Kubernetes Configuration File

```sh
$ kubectl config set-cluster kubernetes-the-hard-way \
--certificate-authority=ca.pem \
--embed-certs=true \
--server=https://${KUBERNETES_PUBLIC_ADDRESS}:6443 \
--kubeconfig=kube-proxy.kubeconfig

$ kubectl config set-credentials system:kube-proxy \
--client-certificate=kube-proxy.pem \
--client-key=kube-proxy-key.pem \
--embed-certs=true \
--kubeconfig=kube-proxy.kubeconfig

$ kubectl config set-context default \
--cluster=kubernetes-the-hard-way \
--user=system:kube-proxy \
--kubeconfig=kube-proxy.kubeconfig

$ kubectl config use-context default --kubeconfig=kube-proxy.kubeconfig

$ ls
kube-proxy.kubeconfig
```

`kube-controller-manager` Kubernetes Configuration File

```sh
$ kubectl config set-cluster kubernetes-the-hard-way \
--certificate-authority=ca.pem \
--embed-certs=true \
--server=https://127.0.0.1:6443 \
--kubeconfig=kube-controller-manager.kubeconfig

$ kubectl config set-credentials system:kube-controller-manager \
--client-certificate=kube-controller-manager.pem \
--client-key=kube-controller-manager-key.pem \
--embed-certs=true \
--kubeconfig=kube-controller-manager.kubeconfig

$ kubectl config set-context default \
--cluster=kubernetes-the-hard-way \
--user=system:kube-controller-manager \
--kubeconfig=kube-controller-manager.kubeconfig

$ kubectl config use-context default --kubeconfig=kube-controller-manager.kubeconfig

$ ls
kube-controller-manager.kubeconfig
```

`kube-scheduler` Kubernetes Configuration File

```sh
$ kubectl config set-cluster kubernetes-the-hard-way \
--certificate-authority=ca.pem \
--embed-certs=true \
--server=https://127.0.0.1:6443 \
--kubeconfig=kube-scheduler.kubeconfig

$ kubectl config set-credentials system:kube-scheduler \
--client-certificate=kube-scheduler.pem \
--client-key=kube-scheduler-key.pem \
--embed-certs=true \
--kubeconfig=kube-scheduler.kubeconfig

$ kubectl config set-context default \
--cluster=kubernetes-the-hard-way \
--user=system:kube-scheduler \
--kubeconfig=kube-scheduler.kubeconfig

$ kubectl config use-context default --kubeconfig=kube-scheduler.kubeconfig

$ ls
kube-scheduler.kubeconfig
```

`admin` Kubernetes Configuration File

 ```sh
$ kubectl config set-cluster kubernetes-the-hard-way \
--certificate-authority=ca.pem \
--embed-certs=true \
--server=https://127.0.0.1:6443 \
--kubeconfig=admin.kubeconfig

$ kubectl config set-credentials admin \
--client-certificate=admin.pem \
--client-key=admin-key.pem \
--embed-certs=true \
--kubeconfig=admin.kubeconfig

$ kubectl config set-context default \
--cluster=kubernetes-the-hard-way \
--user=admin \
--kubeconfig=admin.kubeconfig

$ kubectl config use-context default --kubeconfig=admin.kubeconfig

$ ls
admin.kubeconfig
```

Generating the Data Encryption Config and Key

```sh
$ ENCRYPTION_KEY=$(head -c 32 /dev/urandom | base64)

$ cat > encryption-config.yaml <<EOF
kind: EncryptionConfig
apiVersion: v1
resources:
  - resources:
      - secrets
    providers:
      - aescbc:
          keys:
            - name: key1
              secret: ${ENCRYPTION_KEY}
      - identity: {}
EOF
```


### Bootstrap Things




### Links

- http://pwittrock.github.io/docs/admin/authentication/#creating-certificates
- http://pwittrock.github.io/docs/getting-started-guides/scratch/
