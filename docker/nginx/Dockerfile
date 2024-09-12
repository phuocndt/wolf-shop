FROM nginx:1.25-alpine

ENV TZ=${TZ:-UTC}
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apk add --update --no-cache tzdata

# Modify the user ID (UID) of the nginx user to 1000 to align the nginx user's UID with the UID of Root user for security and permission management purposes.
# RUN usermod -u 1000 nginx

COPY ./default.conf /etc/nginx/conf.d/default.conf
