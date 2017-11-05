### Install and usage kvm

#### Check requirement before install

```egrep -c '(vmx|svm)' /proc/cpuinfo``` # check cpu support
```kvm-ok``` # bios already used
```egrep -c ' lm ' /proc/cpuinfo``` # check if 64

#### Install

```sudo apt-get install qemu-kvm libvirt-bin ubuntu-vm-builder bridge-utils```

#### Add group

sudo adduser `id -un` kvm
sudo adduser `id -un` libvirtd

Note: Some directory will need root:libvirtd

### Download the iso file and put at directory which permission belong to group 'libvirtd'

create os and remember use nat for easy.

### Start directly from kvm:

sudo kvm -hda /var/lib/libvirt/images/ubuntu16.04.qcow2  -m 1024 -name "Ubuntu 16.04" -vga std -net nic -usb -net tap,ifname=tap0,script=no

### Problems

0) Resolution slow. Can go to setting and change resolution. My case (16*9)

1) Copy and paste => install in client: sudo apt install spice-vdagent.
First I can copy from host -> client, restart again I can copy from client->host

2) share directory:

Create and add group t:t for ```~/share``` directory.
chown -R t:t ~/share
chmod -R 775 ~/share

change user and group of file: /etc/libvirt/qemu.conf to t and t. We can check current user run kvm by ps-aux | grep kvm

/etc/init.d/libvirt-bin restart
/etc/init.d/libvirt-guests restart

First file system hardware:
   Driver: Default
   Mode: passthrough
   Source path: /home/t/share
   target path: hostname

go to guest and add module for kernel startup:
sudo nano /etc/modules
add this:

```
loop
virtio
9p
9pnet
9pnet_virtio
```

Load modules:
```service kmod start```

At client machine:
   ```sudo mount hostshare ~/share -t 9p -o trans=virtio```

Because when create the directory when mount with just read. So you cannot create at root directory. Instead create a directory ```~/share/share``` at host and we can edit ~/share/share in guest

To mount at startup add this to /etc/fstab

```hostshare /home/t/share            9p             trans=virtio    0       0```

### References

0) http://rabexc.org/posts/p9-setup-in-libvirt