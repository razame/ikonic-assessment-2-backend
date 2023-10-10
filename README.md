# Project Installation Guide

- Run **"composer install"**
- Run **"php artisan migrate --seed"**
- Run **"php artisan serve"**
- Configure the server url in the frontend project .env file as per described in the Readme.md file of frontend project
- Copy .env.example to .env and add the following lines to it and fill them out
  - CLOUDINARY_API_KEY=
  - CLOUDINARY_CLOUD_NAME=
  - CLOUDINARY_URL=
  - CLOUDINARY_API_SECRET=
- These env variables are for the image uploading on CLOUDINARY CLOUD.
   - **Don't worry its free as well as hassle-free**
- You can then login from the running front-end project with these credentials
  - email: team_lead@ikonic.com
  - password: teamlead123
- You can then create feedback from front end project
