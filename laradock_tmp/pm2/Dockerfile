FROM keymetrics/pm2:10-alpine

VOLUME ["/app"]

RUN apk add --no-cache make gcc g++ python python3
RUN pip3 install s3cmd

RUN mkdir -p /scripts

RUN npm install -g node-gyp

COPY . /scripts

WORKDIR /app


EXPOSE 3333

ENV ACCESS_KEY=CMX2AY2PGYAS3YH7HJ5A
ENV AWS_SECRET_ACCESS_KEY=rUHyLrp9Gp4w7b23fwzkIBTpAU9F/N3J0BeI1znyqUc
ENV AWS_DEFAULT_REGION="nyc3"
ENV S3_BUCKET="zhigalo"
ENV BUCKET_ENDPOINT="https://nyc3.digitaloceanspaces.com"

ENTRYPOINT /scripts/entrypoint.sh
