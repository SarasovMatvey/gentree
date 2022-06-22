FROM php:7.1-alpine

LABEL author="Sarasov Matvey <sarasovmatvej@gmail.com>"  

WORKDIR /gentree/

COPY . . 

ENTRYPOINT [ "php", "index.php" ]