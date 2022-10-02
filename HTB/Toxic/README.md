cookie manipulation
base64 encode

base64 of PHP code and see if it injects

write a PHP code that retrieves the access.log, use the user agent to poison the log in order
to inject a command.

log poisoning < path traversal > user agent manipulation

flag_b5nvv

<?php system('ls -l /');?>

HTB{P0i5on_1n_Cyb3r_W4rF4R3?!}

this reminded me of dogcat.
SERIOUSLY.

so it looks like this is bit of command injection with user agent

try to check if the cookie is vulnerable to script injection.

PHP and encode it to base64 or just don't encode it at all if the cookie isn't decoding the cookie itself.
