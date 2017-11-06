### Examples

Type      Name          Value                     TTL           Explain
A         *.do1         45.55.151.215             1Hour
A         @             Forwarded                 1Hour
CName     wwww          @                         1Hour
NS        @             ns5.domaincontrol.com     1Hour
NS        @             ns06.domaincontrol.com    1Hour
A         *.youtube     45.55.167.153             1Hour         # Fx: my domain is abc.com, so everything abc, whatever.youtube.com.abc.com will match this a record

A: (ipv4) conversion of domain name to corresponding IP address
AAAA(ipv6). like A but ipv6