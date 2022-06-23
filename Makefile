build:
	docker build ./ -t gentree

generate:
	docker run -v $(input_file):/gentree/input.csv \
    -v $(output_dir):/gentree/hostdir/ gentree


