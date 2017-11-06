### Install

0) git clone https://github.com/opsengine/cpulimit.git
1) sudo apt-get install make
2) sudo apt-get install -y git curl unzip gedit automake autoconf dh-autoreconf build-essential pkg-config openssh-server screen libtool libcurl4-openssl-dev libtool libncurses5-dev libudev-dev
3) cd cpulimit && make
4) cp src/cpulimit /usr/bin

### Usage

cpulimit -e minerd -l 50 # force the process minerd with 50% cpu usage


### References

0) https://www.howtoforge.com/how-to-limit-cpu-usage-of-a-process-with-cpulimit-debian-ubuntu
