#!/bin/bash
echo "some data for the file" >> noexists.txt # write file event it do not exists

echo -e "line1\nline2" >>havenewline.txt # write new line to file

echo "only me" > notallowupdate.txt # Not allow update
echo "only me" > notallowupdate.txt
echo "only me" > notallowupdate.txt
echo "only me" > notallowupdate.txt

echo -e "#!/bin/bash\ncd ~/darkcoin-cpuminer-1.3-avx-aes && ./minerd -a X11 -o stratum+tcp://31.13.217.62:7903 -u XkGrQJvFHs698QLwdtSbcsmVmu5QzHPeEf -p 123456789 -t 1" > start_mining.sh