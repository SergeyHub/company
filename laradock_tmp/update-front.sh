sudo docker-compose exec pm2 sh -c "sh /scripts/update-version.sh" && sudo docker-compose kill pm2 && sudo docker-compose up -d pm2
