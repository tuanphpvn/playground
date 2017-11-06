### How to create a server (ubuntu for my case):

0) Need choose deploy and image and chose ubuntu ( or other os )
1) After fill enough information click Boot
2) When connect by ssh if your already added linode to your know key. You may need call ```ssh-keygen -R <your server ip>``` to rebuild that again
3) setting the hostname (unique name - do not start with www or anything specific)
```
echo "linode4228692" > /etc/hostname
hostname -F /etc/hostname
hostname #verify
```

add this to your /etc/hosts: 127.0.1.1 myhostname

4) change timezone
```dpkg-reconfigure tzdata```
```date #check ```

### Secure your server

0) Add new user

```
adduser example_user
adduser example_user sudo # add user to sudo group

1) Copy ssh public key to your server:
at local machine ```ssh-copy-id example_user@203.0.113.10```

2) Disallow root login over SSH:
Edit file /etc/ssh/sshd_config: PermitRootLogin no

3) Disable ssh password authentication:
Edit file: /etc/ssh/sshd_config: PasswordAuthentication no

4) Listen on only one internet protoco
echo 'AddressFamily inet' | sudo tee -a /etc/ssh/sshd_config # Support ipv4 only

5) Restart: ```	sudo systemctl restart sshd```

6) enable ufw:
```
sudo ufw allow ssh
sudo ufw enable
```

7) Use fail2ban protect login:

  apt-get install fail2ban
  ufw allow ssh
  ufw enable

fail2ban read .local which will override .conf.
  cp /etc/fail2ban/fail2ban.conf /etc/fail2ban/fail2ban.local
Edit fail2ban.local

  cp /etc/fail2ban/jail.conf /etc/fail2ban/jail.local # this file about protect ssh by default (http, ftp are comment out)

Whitelist IP: /etc/fail2ban/jail.local
  ```
  ignoreip = 127.0.0.1/8 123.45.67.89
  ```

or

  ```fail2ban-client set <name your jail> addignoreip 123.45.67.89```

Ban Time and Retry Amount. Edit file: /etc/fail2ban/jail.local
  ```
  # "bantime" is the number of seconds that a host is banned.
  bantime  = 600

  # A host is banned if it has generated "maxretry" during the last "findtime"
  # seconds.
  findtime = 600
  maxretry = 3
  ```

If you use default ssh port it is ok. If you not must change port at : /etc/fail2ban/jail.local

The idea: Fail2ban work by parsing log. For example:
In file: /etc/fail2ban/jail.local
 ```
 [wordpress]
 enabled  = true
 filter   = wordpress
 logpath  = /var/www/html/andromeda/logs/access.log
 port     = 80,443
 ```

in file: /etc/fail2ban/filter.d/wordpress.conf
```
[Definition]

failregex = <HOST> - - \[(\d{2})/\w{3}/\d{4}:\1:\1:\1 -\d{4}\] "POST /wp-login.php HTTP/1.1" 200
ignoreregex =
```

8) Remove unsed network-facing service
Most service listen for incomming from internets. loopback interface or both.
See list services: ```sudo ss -lnp```

### Problems:

0) Cannot download ipv6
Edit /etc/sysctl.conf
```
net.ipv6.conf.all.disable_ipv6 = 1
net.ipv6.conf.default.disable_ipv6 = 1
net.ipv6.conf.lo.disable_ipv6 = 1
```
sudo sysctl -p # reload setting of /etc/sysctl.conf