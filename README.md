## About
r2cloud reader webpage read recorded data and show it with web interface without login
 
## Screenshots

<img src="https://raw.githubusercontent.com/Lukas0025/r2cloud-reader-webpage/master/screens/1.png" width="50%">&nbsp;<img src="https://raw.githubusercontent.com/Lukas0025/r2cloud-reader-webpage/master/screens/2.png" width="50%">&nbsp;<img src="https://raw.githubusercontent.com/Lukas0025/r2cloud-reader-webpage/master/screens/3.png" width="50%">&nbsp;<img src="https://raw.githubusercontent.com/Lukas0025/r2cloud-reader-webpage/master/screens/4.png" width="50%">&nbsp;<img src="https://raw.githubusercontent.com/Lukas0025/r2cloud-reader-webpage/master/screens/5.png" width="50%">


## Installation 

1. Install r2cloud more info here [https://github.com/dernasherbrezon/r2cloud](https://github.com/dernasherbrezon/r2cloud)
2. setup r2cloud reader webpage
    - On same machine where r2cloud running
        - With docker
            - copy config-sample.php to config.php and edit it
                - r2_patch - do not change!!!
                - r2_url   - do not change!!!
                - set other config if you want
            - docker run -d -p 80:80 {config file patch}:/var/www/data/config.php {r2cloud data patch (~/r2cloud/data)}:/var/www/data/data lukasplevac/r2cloud-reader-webpage
        - Without docker
            - install apache2 with php support
            - copy config-sample.php to config.php and edit it
                - set r2_patch - it is full patch to r2cloud/ (forder where is data)
                - set r2_url   - it is full/relative url to r2cloud/ (forder where is data) - access from web -> must be addresed as http:// outside the device!!!
                - set other config if you want
            - copy src/* to your www dir
    - On other machine
        - With docker
            - add cron with RSYNC to sync r2cloud/data forder
            - copy config-sample.php to config.php and edit it
                - r2_patch - do not change!!!
                - r2_url   - do not change!!!
                - set other config if you want
            - docker run -d -p 80:80 {config file patch}:/var/www/data/config.php {r2cloud data patch (~/r2cloud/data)}:/var/www/data/data lukasplevac/r2cloud-reader-webpage
        - Without docker
            - add cron with RSYNC to sync r2cloud/data forder
            - install apache2 with php support
            - copy config-sample.php to config.php and edit it
                - set r2_patch - it is full patch to r2cloud/ (forder where is data)
                - set r2_url   - it is full/relative url to r2cloud/ (forder where is data) - access from web -> must be addresed as http:// outside the device!!!
                - set other config if you want
            - copy src/* to your www dir

