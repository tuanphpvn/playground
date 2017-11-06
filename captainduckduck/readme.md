### Install
sudo mkdir /captain
sudo chown -R <user>:<group> /captain

docker run -v /var/run/docker.sock:/var/run/docker.sock dockersaturn/captainduckduck

### Stop docker swarm

docker service rm $(docker service ls -q)
docker swarm leave --force
