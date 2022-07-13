# Discord Server Insights Visualizer
A small PHP web app to help compile Discord Insights CSV exports of visitors and message activity into graphical data - helps geta round their minimal-length data retention for longer analytical views.

## Usage
After cloning this repo to your local machine, you'll need to install the dependencies via composer.
```
composer install
```

Run that in the CLI from your project's root. You must have composer installed in your system's PATH.

Copy the `app/nox-env.example.php` file to `app/nox-env.php` to create the pseudo environment file.

Verify you have a database schema via MySQL to put the database tables in. Enter your database schema and credentials in the `app/nox-env.php` file.

Then, run the following from the CLI

```
php app/cli-scripts/sync-models.php
```

This will create the necessary MySQL tables and columns to use this application.

## Adding Data
Go to Discord server Insights and click the "Engagements" tab. Set your view of these graph intervals to "Daily" in the first dropdown menu. You can select any date range you want - however, the longer the better. This application will not import duplicate dates, so overlapping data exports are fine.

There will be three graphs we are concerned with. Export CSVs of the `How many members visited and communicated?`, `Message activity`, and the `How many people muted my server?` graphs.

Once you download these three CSVs, put them into a folder with any name you like.

Then, move that folder into this application in the directory of `app/resources/insights-exports`

Finally, run the following in the command line

```
php app/cli-scripts/run-import.php
```

This will import any CSV exports into the database. Again, duplicate timestamps are ignored. You will see errors in the console about duplicate entries for overlapping data. This is normal.

## Viewing the Data
Host this application via Apache in some form - on local machines it's recommended to just use XAMPP. ***Make sure the document root is set to `app`*** and not the actual project root.

Then, view the index and you will see the graph.
