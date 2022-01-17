
$route->resource("6",['controller'=>'Produk\produk','only'=>['index','show','create','update','delete']]);
$route->put("6",'Produk\produk::update');
$route->delete("6",'Produk\produk::delete');
