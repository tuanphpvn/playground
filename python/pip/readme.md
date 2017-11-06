### Install pip

0) Download get-pip.py: https://bootstrap.pypa.io/get-pip.py
1) python get-pip.py

### Problems

0) You do not have permission

chown -R t:t /usr/local

1) AFter run pip get-pip.py but cannot run pip.

Remove complete pip: python -m pip uninstall pip setuptools
Install again: pip get-pip.py
Success


