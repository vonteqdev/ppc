<?xml version="1.0" encoding="UTF-8"?>
<feed>
    @foreach ($products as $product)
    <product>
        <id>{{ $product->id }}</id>
        <name>{{ $product->name }}</name>
        <price>{{ $product->price }}</price>
        <availability>{{ $product->availability }}</availability>
        <labels>
            @foreach ($product->labels as $label)
            <label>{{ $label }}</label>
            @endforeach
        </labels>
    </product>
    @endforeach
</feed>
