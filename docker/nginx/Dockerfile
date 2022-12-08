FROM nginx:1.23.1-alpine
RUN apk update && apk upgrade \
    && apk add bash nano less tzdata \
    && cp /usr/share/zoneinfo/Europe/Minsk /etc/localtime \
    && echo "Europe/Minsk" > /etc/timezone \
    && apk del tzdata
EXPOSE 80
