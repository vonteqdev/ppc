<?xml version="1.0" encoding="UTF-8"?>
<feed>
    @foreach ($products as $product)
    <product>
        <id>{{ $product->id }}</id>
        <title>{{ $product->title }}</title>
        <price>{{ $product->price }}</price>
        <availability>{{ $product->availability }}</availability>
        <custom_label>{{ $product->custom_label }}</custom_label>
    </product>
    @endforeach
</feed>
