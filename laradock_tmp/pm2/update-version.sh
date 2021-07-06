# итерируем версию
node /scripts/set_version.js

# билдим
npm install
npm run build

version=$(node -p "require('/app/version.json').version")

# грузим на s3

s3cmd put /app/releases/${version}/dist/client s3://${S3_BUCKET}/static/ \
                      -c /scripts/config.s3cfg \
                      --acl-public \
                      --add-header=Cache-Control:max-age=31536000 \
                      --recursive

s3cmd put /app/releases/${version}/dist/client/* s3://${S3_BUCKET}/static/ \
                      -c /scripts/config.s3cfg \
                      --acl-public \
                      --add-header=Cache-Control:max-age=31536000 \
                      --recursive

s3cmd -c /scripts/config.s3cfg put /app/static/* s3://${S3_BUCKET} \
                      -c /scripts/config.s3cfg \
                      --acl-public \
                      --add-header=Cache-Control:max-age=31536000 \
                      --recursive

# меняем симлинк
rm -rf current && ln -s releases/${version} current
