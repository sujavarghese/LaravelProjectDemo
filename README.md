

## Network Boundary Design Exchange


This is an application for Network Boundary Design Exchange built on Laravel PHP, MySQL and Bootstrap. 


## What's done


* User Authentication
* Dashboard
    - Display User details and activities performed.
* Boundary Loader 
    - CSV upload, validate and load into MySQL Database
    - Boundary details tab view


## What's coming next


Incorporate ReactJS, Maps, KML into the application.

The final application is expected to have a number of features. 
* Dashboard
    - Display user activities with graphical representation
* Boundary Loader tool
    - Support KML file type
* Boundary Exporter
    - Support file types viz., KML, MapInfo
* Map Viewer
    - View uploaded data in the map and export selected boundary
* Search
    - Search boundary by name and export


## Installation Steps


1.Open cmd prompt and move to your destination folder

    run git clone https://github.com/sujavarghese/LaravelProjectDemo.git

2. Go to <destination folder>/LaravelProjectDemo

    2.1 `composer install`

    2.2 `cp .env.example .env`
    
    2.3 open .env and modify configs as below 

        DB_DATABASE=laraveldemodb

        DB_USERNAME=root

        DB_PASSWORD=

    2.4 `php artisan key:generate`

    2.5 open phpmyadmin and create a new database as `laraveldemodb`

    2.6 `php artisan migrate` 

    2.7 `php artisan serve`

    2.8 Open browser and redirect to http://127.0.0.1:8000 [where the demo is running]

    2.9 Click on register link and create an User
    
    
You can find a sample input file under `tests\TestData`

## Changelog


0.4 UI enhancements

0.3 Added Boundary Upload and Store

0.2 Added Dashboard

0.1 Initial Release
