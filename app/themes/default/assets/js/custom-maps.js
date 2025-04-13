(function ($) {
    "use strict";
    var markerIcon = {
        anchor: new google.maps.Point(10, 15),
        url: 'images/map-marker.png',
    };

    function fullMap() {
        function itemData(itemURL, itemCategory, itemImg, itemTitle, itemAddress, itemPhone, itemOpen, itemRating, itemReviewCounter) {
            return ('<div class="map-info-popup"><div class="item-popup-box"><span class="close-info"><i class="la la-close"></i></span><span class="map-badge">' + itemCategory + '</span><a href="' + itemURL + '" class="map-img-box position-relative d-block"><img src="' + itemImg + '" alt=""></a> <div class="item-list-content position-relative"><h4 class="mb-2"><a href=' + itemURL + '>' + itemTitle + '</a></h4><div class="item-ratting mb-3" data-star-rating="' + itemRating + '"><span class="map-review-count">' + itemReviewCounter + ' reviews</span></div><span class="location-info d-block mb-2"><i class="la la-map-marker"></i>' + itemAddress + '</span><span class="item-call d-block mb-2"><i class="la la-phone"></i>' + itemPhone + '</span><span class="item-call d-block"><i class="la la-clock-o"></i>' + itemOpen + '</span></div></div></div>')
        }
        var locations = [
            [itemData(
                "tour-right-sidebar.html",
                "Restaurant",
                "images/img1.jpg",
                "Brenda French Soul Food Restaurant",
                "121 West Parkview, London ",
                "+1246-345-0695",
                " Open Now",
                "5",
                "27"
            ),
                42.5620277,
                12.5930638,
                0,
                markerIcon
            ],
            [itemData(
                "tour-right-sidebar.html",
                'Travel',
                'images/img2.jpg',
                'The Blue Beach',
                "34 Parkview, New York, USA",
                "+1246-345-0695",
                "Closed. Open at 6:30 AM - 11PM",
                "4",
                "12"
            ),
                24.6900406,
                46.7109742,
                0,
                markerIcon
            ],
            [itemData(
                "tour-right-sidebar.html",
                'Hotel & Restaurant',
                'images/img1.jpg',
                'The Party Center',
                "181 Wellington Street, M5V 3G7 Toronto",
                "+1246-345-0695",
                "Now Open",
                "5",
                "52"
            ),
                43.6421237,
                -79.3803969,
                0,
                markerIcon
            ],
            [itemData(
                "tour-right-sidebar.html",
                'Travel',
                'images/img2.jpg',
                'Maldana Blue Beach Resort',
                "Montreal Street, QC H3B, Canada ",
                "+1246-345-0695",
                "Now Open",
                "5",
                "27"
            ),
                41.7948911,
                -88.0054919,
                0,
                markerIcon
            ],
            [itemData(
                "tour-right-sidebar.html",
                'Hotel',
                'images/img3.jpg',
                'Monopoly Rest the Center',
                "131 The Esplanade, Toronto, ON M5A 4P5, Canada",
                "+1246-345-0695",
                "Closed. Open at 6:30 AM - 11PM",
                "5",
                "12"
            ),
                43.650005,
                -79.379946,
                0,
                markerIcon
            ],
            [itemData(
                "tour-right-sidebar.html",
                'Event',
                'images/img4.jpg',
                'Bodega Garage - Filipino Night Club',
                "10, Aberdeen, United Kingdom",
                "+1246-345-0695",
                "Now Open",
                "5",
                "12"
            ),
                40.7312782,
                -74.2170747,
                0,
                markerIcon
            ],
            [itemData(
                "tour-right-sidebar.html",
                'Hotels',
                'images/img5.jpg',
                'Luxary Rest Hotel',
                "370, Calgary, AB 3H7, Canada",
                "+1246-345-0695",
                "Now Open",
                "5",
                "17"
            ),
                543.651521,
                -79.37782,
                0,
                markerIcon
            ],
            [itemData(
                "tour-right-sidebar.html",
                'Gym',
                'images/img6.jpg',
                'Perform For Life - Hayes Valley',
                "London, United Kingdom",
                "+1246-345-0695",
                "Now Open",
                "5",
                "22"
            ),
                47.0962411,
                2.4587676,
                0,
                markerIcon
            ],
            [itemData(
                "tour-right-sidebar.html",
                'Bear & Bar',
                'images/img7.jpg',
                'Collin Bear Bar',
                "2545 Montreal Street, Canada",
                "+1246-345-0695",
                "Closed. Open at 6:30 AM - 11PM",
                "4",
                "11"
            ),
                43.9959016,
                -72.6871069,
                0,
                markerIcon
            ],
            [itemData(
                "tour-right-sidebar.html",
                'Art & Design',
                'images/img8.jpg',
                'Kamran\'s Art & Design Center ',
                "323,Kamran Avenue, New York, USA",
                "+1246-345-0695",
                "Now Open",
                "5",
                "12"
            ),
                24.691415,
                46.7175295,
                0,
                markerIcon
            ],
            [itemData(
                "tour-right-sidebar.html",
                'Event and Conference',
                'images/img1.jpg',
                'Graphic Design Conference',
                "280 Adelaide St W, Toronto, ON M5V 1P6, Canada",
                "+1246-345-0695",
                "Open at 6:30 AM - 11PM",
                "5",
                "17"
            ),
                43.6477128,
                -79.3930809,
                0,
                markerIcon
            ],
            [itemData(
                "tour-right-sidebar.html",
                'Hotels',
                'images/img9.jpg',
                'Monolight Hotel',
                "40 Journal Square Plaza, NJ, USA",
                "+1246-345-0695",
                "Closed. Open at 6:30 AM - 11PM",
                "4",
                "32"
            ),
                41.0346449,
                28.9776183,
                0,
                markerIcon
            ],
            [itemData(
                "tour-right-sidebar.html",
                'Hotels',
                'images/img10.jpg',
                'Moonlight Party Hotel',
                "40 Journal Square Plaza, NJ, USA",
                "+1246-345-0695",
                "Now Open",
                "5",
                "22"
            ),
                39.7449686,
                -88.6840435,
                0,
                markerIcon
            ],
            [itemData(
                "tour-right-sidebar.html",
                'Restaurants',
                'images/img1.jpg',
                'The Goggi Restaurant',
                "101 Intervale Ave, Bronx, NY, USA",
                "+1246-345-0695",
                "Closed. Open at 6:30 AM - 11PM",
                "4",
                "10"
            ),
                43.651521,
                -79.37782,
                0,
                markerIcon
            ],
            [itemData(
                "tour-right-sidebar.html",
                "Hotels",
                "images/img11.jpg",
                "New Year Eve Party",
                "102, Strasbourg, France",
                "+1246-345-0695",
                "Now Open",
                "4",
                "11"
            ),
                37.2582904,
                -102.6537497,
                0,
                markerIcon
            ],
            [itemData(
                "tour-right-sidebar.html",
                "Hotels",
                "images/img1.jpg",
                "New Year Eve Party",
                "102, Strasbourg, France",
                "+1246-345-0695",
                "Now Open",
                "5",
                "42"
            ),
                51.255512,
                22.5733453,
                0,
                markerIcon
            ]

        ];

        var map = new google.maps.Map(document.getElementById('map-wrap'), {
            zoom: 3,
            scrollwheel: false,
            center: new google.maps.LatLng(40.7168873, -74.1627538),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            zoomControl: true,
            mapTypeControl: false,
            fullscreenControl: false,
            styles: [
                {
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#e9e9e9"
                        },
                        {
                            "lightness": 17
                        }
                    ]
                },
                {
                    "featureType": "landscape",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#f5f5f5"
                        },
                        {
                            "lightness": 20
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#ffffff"
                        },
                        {
                            "lightness": 17
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry.stroke",
                    "stylers": [
                        {
                            "color": "#ffffff"
                        },
                        {
                            "lightness": 29
                        },
                        {
                            "weight": 0.2
                        }
                    ]
                },
                {
                    "featureType": "road.arterial",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#ffffff"
                        },
                        {
                            "lightness": 18
                        }
                    ]
                },
                {
                    "featureType": "road.local",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#ffffff"
                        },
                        {
                            "lightness": 16
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#f5f5f5"
                        },
                        {
                            "lightness": 21
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#dedede"
                        },
                        {
                            "lightness": 21
                        }
                    ]
                },
                {
                    "elementType": "labels.text.stroke",
                    "stylers": [
                        {
                            "visibility": "on"
                        },
                        {
                            "color": "#ffffff"
                        },
                        {
                            "lightness": 16
                        }
                    ]
                },
                {
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "saturation": 36
                        },
                        {
                            "color": "#333333"
                        },
                        {
                            "lightness": 40
                        }
                    ]
                },
                {
                    "elementType": "labels.icon",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "transit",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#f2f2f2"
                        },
                        {
                            "lightness": 19
                        }
                    ]
                },
                {
                    "featureType": "administrative",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#fefefe"
                        },
                        {
                            "lightness": 20
                        }
                    ]
                },
                {
                    "featureType": "administrative",
                    "elementType": "geometry.stroke",
                    "stylers": [
                        {
                            "color": "#fefefe"
                        },
                        {
                            "lightness": 17
                        },
                        {
                            "weight": 1.2
                        }
                    ]
                }
            ]
        });

        var mapInfoBox = document.createElement("div");
        mapInfoBox.className = 'map-info-box';
        var currentInfoBox;
        var boxOptions = {
            content: mapInfoBox,
            disableAutoPan: true,
            alignBottom: true,
            pixelOffset: new google.maps.Size(-146, -35),
            boxStyle: {
                width: "310px"
            },
            closeBoxMargin: "0",
            closeBoxURL: ""
        };

        var markerCluster, marker, i;
        var allMarkers = [];
        var clusterStyles = [{
            textColor: 'white',
            url: '',
            height: 50,
            width: 50
        }];


        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                icon: locations[i][4],
                id: i
            });
            allMarkers.push(marker);
            var ib = new InfoBox();
            google.maps.event.addListener(ib, "domready", function () {
                itemRatting()
            });
            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    ib.setOptions(boxOptions);
                    mapInfoBox.innerHTML = locations[i][0];
                    ib.close();
                    ib.open(map, marker);
                    currentInfoBox = marker.id;
                    var latLng = new google.maps.LatLng(locations[i][1], locations[i][2]);
                    map.panTo(latLng);
                    map.panBy(0, -180);
                    google.maps.event.addListener(ib, 'domready', function () {
                        $('.close-info').click(function (e) {
                            e.preventDefault();
                            ib.close();
                        });
                    });
                }
            })(marker, i));
        }
        var options = {
            imagePath: '../images/',
            styles: clusterStyles,
            minClusterSize: 2
        };
        markerCluster = new MarkerClusterer(map, allMarkers, options);
        google.maps.event.addDomListener(window, "resize", function () {
            var center = map.getCenter();
            google.maps.event.trigger(map, "resize");
            map.setCenter(center);
        });

    }
    var map = document.getElementById('map-wrap');

    if (typeof (map) != 'undefined' && map != null) {
        google.maps.event.addDomListener(window, 'load', fullMap);
    }

})(this.jQuery);