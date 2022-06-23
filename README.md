
## Usage


1. Скачать репозиторий

``` bash
  git clone https://github.com/SarasovMatvey/gentree.git
```

2. Перейти в папку с проектом

``` bash
cd gentree
```

3. Собрать Docker образ через Makefile

``` bash
make build
```

4. Наконец - запустить команду для генерации json дерева

``` bash
make generate input_file=<путь до csv файла> output_dir=<путь к папке в которую будет загружено json дерево>
```

Пример:

``` bash
make generate input_file=/home/matvey/work/gentree/input.csv output_dir=/home/matvey/work/gentree/tests
```