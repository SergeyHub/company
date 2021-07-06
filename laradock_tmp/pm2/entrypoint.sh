#cp -R /app/. /var/www/app && rm -rf /var/www/node_modules
#cd /var/www/app && npm install && npm rebuild node-sass && npm run build
#aws s3 sync /var/www/app/.nuxt/dist/client s3://"$S3_BUCKET"/static/ --cache-control max-age=31536000,public
#aws s3 sync /var/www/app/static s3://"$S3_BUCKET"/assets/ --cache-control max-age=31536000,public
#aws s3 sync /var/www/app/static/fonts s3://"$S3_BUCKET"/fonts/ --cache-control max-age=31536000,public
#aws s3 sync /var/www/app/static/img s3://"$S3_BUCKET"/img/ --cache-control max-age=31536000,public
#pm2-runtime start pm2.json
#npm install && npm rebuild node-sass && /scripts/update-version.sh &&
#cd /app && npm install && npm run build
pm2-runtime start /scripts/pm2.json
