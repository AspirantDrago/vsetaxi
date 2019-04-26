function init(){
    // Создание карты.
    var myMap = new ymaps.Map("back_map", {
        center: [53.630403, 55.930825],
        zoom: 12
    });
}

if($('#back_map').length) {
    ymaps.ready(init);
}