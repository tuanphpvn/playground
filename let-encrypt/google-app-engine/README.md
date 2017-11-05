### Install letencrypt

0) sudo apt-get install letsencrypt
1) letsencrypt certonly --manual -d mydeveloper.info
2) make request for: http://mydeveloper.info/.well-known/acme-challenge/4X1meJjk7D26ItwlzxYZeeUE5aw-SD1uP_bxm2w9Eaw by change app.yml
3) go to (https://console.cloud.google.com/appengine/settings/certificates) and paste the private.pem and public.pem:
4) generate private key:  openssl rsa -in /etc/letsencrypt/keys/<lastversion>_key-letsencrypt.pem -out private-rsa.pem. copy content of private-rsa.pem as private key
5) copy public key: content of fullchain.pem as public key.
cat /etc/letsencrypt/live/mydeveloper.info/fullchain.pem | xsel --clipboard
6) use new key for your domain. Done

### Problems

1) The client sent an unacceptable anti-replay nonce => Letsencrypt wait too long. Run command again and it fix
