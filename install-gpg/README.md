### Install GnuPG

https://www.gnupg.org/download/

Note: Use Libgcrypt(1.7.4)

### Generate key

1) gpg-agent --daemon --pinentry-program /usr/local/bin/pinentry

2) gpg2 --gen-key

3) gpg2 --list-secret-keys --keyid-format LONG

Example Output:

sec   4096R/3AA5C34371567BD2 2016-03-10 [expires: 2017-03-10]
uid                          Hubot
ssb   4096R/42B317FD4BA89E7A 2016-03-10

gpg2 --armor --export 3AA5C34371567BD2

Copy that publish key

### Github settings

https://help.github.com/articles/adding-a-new-gpg-key-to-your-github-account/