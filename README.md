# pihole-Simple-Whitelist
Easy way for anyone to add a domain to the pihole whitelist without admin access

## Showcase
<img src="https://github.com/user-attachments/assets/bc6a6a21-bef2-41e1-b392-75e0d86176bc" width="700"></img>
<img src="https://github.com/user-attachments/assets/44f0aefa-812f-494e-89f0-693521d02b5e" height="402"></img>
<img src="https://github.com/user-attachments/assets/fb2551e6-0151-4690-a99b-d045f6d30fbc" width="600"></img>

## Install
1. In `/var/www/html/`, create a folder `whitelist`
2. Drop `index.html`, `style.css` and `whitelist-add.php` into it
3. Get and copy your pihole webui password hash `cat /etc/pihole/setupVars.conf | grep WEBPASSWORD`
4. Edit `whitelist-add.php`, set `$auth` on line 16 to your password hash
5. Try to visit http://pi.hole/whitelist/
