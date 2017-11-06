### Common usage

docker ps -a # List container
docker exec -it <containerIdOrName> bash
docker stop <containerid> # stop container
docker rm <containerid> #remove container
docker images # list images
docker rmi -f <imageid> # force remove image

docker stop $(docker ps -a -q)

systemctl stop docker #stop docker