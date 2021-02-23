FROM golang:1.18 as build

RUN mkdir -p /app
RUN apt-get update

WORKDIR /app

COPY ./ ./

RUN go build -v -ldflags="-X 'main.version=v1.0.0'" caterpillar.go

FROM ubuntu:22.04

RUN apt-get update

RUN mkdir -p /app/configs
RUN mkdir -p /app/var/logs

WORKDIR /app

COPY --from=build /app/caterpillar /app/caterpillar
COPY --from=build /app/config.dist.yml /app/configs/config.dist.yml

EXPOSE 8000

VOLUME /app/configs
VOLUME /app/var

RUN ./caterpillar version

CMD ["./caterpillar", "server", "-c", "/app/configs/config.dist.yml"]
