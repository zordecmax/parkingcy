export const mapStyles = [
    {
        featureType: "all",
        elementType: "labels",
        stylers: [
            { visibility: "off" }, // Скрыть все метки
        ],
    },
    {
        featureType: "administrative.neighborhood",
        elementType: "geometry",
        stylers: [
            { visibility: "on" }, // Показать районы
        ],
    },
    {
        featureType: "administrative.neighborhood",
        elementType: "labels.text",
        stylers: [
            { visibility: "on" }, // Показать текстовые метки районов
        ],
    },
    {
        featureType: "road",
        elementType: "geometry",
        stylers: [
            { visibility: "on" }, // Показать дороги
        ],
    },
    {
        featureType: "road",
        elementType: "labels",
        stylers: [
            { visibility: "off" }, // Скрыть метки дорог
        ],
    },
    {
        featureType: "poi",
        elementType: "geometry",
        stylers: [
            { visibility: "on" }, // Показать ориентиры
        ],
    },
    {
        featureType: "poi",
        elementType: "labels",
        stylers: [
            { visibility: "off" }, // Скрыть метки ориентиров
        ],
    },
];
