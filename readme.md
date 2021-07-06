## Run in development
1. Install docker and docker-compose.
2. Clone repository
```
git clone github.com/SergeyHub/company.git
cd company
```

3. Configure .env file
```
cp .env.example .env
```
4. Add test domain to hosts
```
echo "company.test 127.0.0.1" >> /etc/hosts
```
5. Build docker services.
```
cd laradock
cp .env.example .env
./build.sh
```
6. Kill pm2 service and run nuxt in other terminal window.
```
docker-compose kill pm2
cd ../frontend && npm i && npm run dev
```
