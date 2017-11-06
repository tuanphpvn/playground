### Install

-1) remove old one if have: ```sudo apt-get remove docker docker-engine docker.io```
0) sudo apt-get update
1)  sudo apt-get install \
       apt-transport-https \
       ca-certificates \
       curl \
       software-properties-common

2) curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
3) sudo apt-key fingerprint 0EBFCD88
4) sudo add-apt-repository \
      "deb [arch=amd64] https://download.docker.com/linux/ubuntu \
      $(lsb_release -cs) \
      stable"

5) sudo apt-get update
6) sudo apt-get install docker-ce

### Upgrade remove and run install again

### Uninstall

sudo apt-get purge docker-ce

to remove all images, container and volumen: sudo rm -rf /var/lib/docker

### Run docker without root.

Because docker run in unix socket with group docker. Docker daemon always run as root. but you can run the client as a user in docker group then you don't need to add sudo.

Create unix group called docker and add user to it. when daemon run it will make the ownership of unix socket read/write by docker group.

sudo groupadd docker
sudo gpasswd -a $USER docker

run ```newgrp docker``` or logout to change info about group

