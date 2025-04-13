<style>
  .navbar{display:none}
  footer{display:none}
  .mob-bg{display:none;}
  .footerbg{display:none;}
  .footer_bg{display:none;}
  #header-waypoint-sticky{display:none;}
</style>
<br>
<div class="container" style="margin-top:35px">
  <div class="bt-collapse-wrapper as-toggle">
    <div class="collapse-item">
      <div class="collapse-header" id="toggleStyle04-headingOne">
        <h5 class="collapse-title">
          <a class="collapse-link" data-toggle="collapse" data-target="#toggleStyle04-collapseOne" aria-expanded="false" aria-controls="toggleStyle04-collapseOne">
          API Information
          </a>
        </h5>
      </div>
      <div id="toggleStyle04-collapseOne" class="collapse show" aria-labelledby="toggleStyle04-headingOne" style="">
        <div class="collapse-body">
          <div class="collapse-inner form-horizontal">
            <?php if(empty($apiKeySession)){ ?>
            <div class="row">
              <div class="col-md-8 form-horizontal">
                <form action="" method="POST">
                  <div class="row form-group">
                    <label class="col-md-3 control-label text-left">Please Enter API Key</label>
                    <div class="col-md-6">
                      <input type="text" class="form-control" name="key" placeholder="API Key" required />
                    </div>
                    <label class="col-md-3">  <input type="submit" class="btn-block btn btn-success" name="submit" value="Submit" /></label>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End API Key form -->
<?php }else{ $invoiceIframeUrl = "In response an invoice url will be returned, which can be used in an iframe to show invoice."; ?>
This API allows you to search for All modules data and availabilty in real-time across inventory. The service is available via standard HTTP POST/GET request and responses are made available in JSON format.
<br><br>
<h3>Authentication</h3>
<p>In order to make requests to <?php echo base_url();?>api/, you must send "appKey" as parameter passing the appKey which has been set in application settings mobile panel. Only share your "appKey" with those who you want to show the API Requests and Responses. </p>
<div class="panel-group" id="accordion">
  <!-- Start Modules -->
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#MODULES">
        Modules</a>
      </h4>
    </div>
    <div id="MODULES" class="panel-collapse collapse in">
      <div class="panel-body">
        <h4>  - Get modules list with statuses </h4>
        <p><strong><span class="text-primary">GET</span> : <?php echo base_url(); ?>api/modulesinfo/list?appKey=<?php echo $apikey; ?></strong></p>
        <p><strong class="text-danger">Response</strong></p>
        <pre>
{
  "response": [
    {
      "title": "Hotels",
      "status": true
    },
    {
      "title": "Flights",
      "status": true
    },
    {
      "title": "Tours",
      "status": true
    },
    {
      "title": "Cars",
      "status": true
    },
<!--     {
      "title": "Cruise",
      "status": false
    }, -->
    {
      "title": "Visa",
      "status": true
    },
    {
      "title": "Newsletter",
      "status": true
    },
    {
      "title": "Coupons",
      "status": true
    },
    {
      "title": "Locations",
      "status": true
    },
    {
      "title": "Blog",
      "status": true
    },
    {
      "title": "Offers",
      "status": true
    }
  ],
  "error": {
    "status": false,
    "msg": ""
  }
}

              </pre>
      </div>
    </div>
  </div>
  <!-- End Modules -->
  <!-- Start Hotels -->
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#HOTELS">
        Hotels</a>
      </h4>
    </div>
    <div id="HOTELS" class="panel-collapse collapse">
      <div class="panel-body">
        <h4>  - Get Hotels list </h4>
        <p><strong><span class="text-primary">GET</span> : <?php echo base_url(); ?>api/hotels/list?appKey=<?php echo $apikey; ?></strong></p>
        <p><strong class="text-danger">Response</strong></p>
        <pre>
{
  "response": [
    {
      "id": "40",
      "title": "Rendezvous Hotels",
      "slug": "http://yourdomain.com/hotels/singapore/singapore/Rendezvous-Hotels?&checkin=24/10/2016&checkout=25/10/2016&adults=2&child=0",
      "thumbnail": "http://yourdomain.com/uploads/images/hotels/slider/thumbs/75043_1.jpg",
      "starsCount": "2",
      "location": "Singapore",
      "desc": "Rendezvous Hotel Singapore is located in the Arts and Heritage District, within 3 km (0.2 mi) of the Singapore National Museum, Singapore Art Museum, and Singapore Management University. The Dhoby Ghaut MRT (Mass Rapid Transit) station is a five-minute walk, and Orchard Road shops are a 10-to-15-minute walk. Hotel Features. The exterior of the building combines history and sophistication, while the interior offers an art-infused experience and a unique aesthetic. The hotel offers an outdoor pool, and a fitness center. Public areas and all guestrooms are nonsmoking. Straits Cafe@Rendezvous offers buffet and a la carte dining. Room service is available around the clock. A lobby bar and a gourmet food court are also on site. The hotel offers a concierge desk, a multilingual staff, and business services. Guestrooms. The air-conditioned guestrooms feature cable TV, pay movies, and in-room safes. Wireless and wired high-speed Internet access are available for a surcharge. Minibars and coffee/tea makers are also included. Bathrooms offer shower/tub combinations, handheld showers, and telephones. Wake-up calls are provided upon request",
      "price": "1,100",
      "currCode": "USD",
      "currSymbol": "$",
      "amenities": [
        {
          "icon": "http://yourdomain.com/uploads/images/hotels/amenities/522827_airport.png",
          "name": "Airport Transport"
        },
        {
          "icon": "http://yourdomain.com/uploads/images/hotels/amenities/593292_receptionist.png",
          "name": "Business Center"
        },
        {
          "icon": "http://yourdomain.com/uploads/images/hotels/amenities/920288_wheelchar.png",
          "name": "Disabled Facilities"
        },
        {
          "icon": "http://yourdomain.com/uploads/images/hotels/amenities/78888_club.png",
          "name": "Night Club"
        },
        {
          "icon": "http://yourdomain.com/uploads/images/hotels/amenities/813018_laundry.png",
          "name": "Laundry Service"
        },
        {
          "icon": "http://yourdomain.com/uploads/images/hotels/amenities/53193_858245_wifi.png",
          "name": "Wi-Fi Internet"
        },
        {
          "icon": "http://yourdomain.com/uploads/images/hotels/amenities/906341_bar.png",
          "name": "Bar Lounge"
        },
        {
          "icon": "http://yourdomain.com/uploads/images/hotels/amenities/926605_811401_poll.png",
          "name": "Swimming Pool"
        },
        {
          "icon": "http://yourdomain.com/uploads/images/hotels/amenities/6348_541779_parking.png",
          "name": "Inside Parking"
        },
        {
          "icon": "http://yourdomain.com/uploads/images/hotels/amenities/117737_653168_busstation.png",
          "name": "Shuttle Bus Service"
        },
        {
          "icon": "http://yourdomain.com/uploads/images/hotels/amenities/403809_764557_fitness.png",
          "name": "Fitness Center"
        },
        {
          "icon": "http://yourdomain.com/uploads/images/hotels/amenities/308869_654419_spa.png",
          "name": "SPA"
        },
        {
          "icon": "http://yourdomain.com/uploads/images/hotels/amenities/124634_ac.png",
          "name": "Air Conditioner"
        },
        {
          "icon": "http://yourdomain.com/uploads/images/hotels/amenities/524780_card.png",
          "name": "Cards Accepted"
        },
        {
          "icon": "http://yourdomain.com/uploads/images/hotels/amenities/999481_elevator.png",
          "name": "Elevator"
        },
        {
          "icon": "http://yourdomain.com/uploads/images/hotels/amenities/179352_pet.png",
          "name": "Pets Allowed"
        }
      ],
      "avgReviews": {
        "clean": 2.7,
        "comfort": 6.3,
        "location": 7.7,
        "facilities": 6.7,
        "staff": 5.3,
        "totalReviews": "3",
        "overall": 5.7
      },
      "latitude": "1.354313975537631",
      "longitude": "103.81743274072267"
    }
  ],
  "error": {
    "status": false,
    "msg": ""
  },
  "totalPages": 2
}
    </pre>
        <h4>  - Hotels Search </h4>
        <p><strong><span class="text-primary">GET</span> : <?php echo base_url(); ?>api/hotels/search?appKey=<?php echo $apikey; ?></strong></p>
        <p>Parameter 1: appKey => Your App Key</p>
        <p>Parameter 2: checkin => Check-In Date (MM/DD/YYYY)</p>
        <p>Parameter 3: checkout => Check-Out Date (MM/DD/YYYY)</p>
        <p>Parameter 4: searching => Location ID</p>
        <p><strong class="text-danger">Response</strong></p>
        <pre>
      {
         "response":[
            {
               "id":"29",
               "title":"Tria Hotel Istanbul Special",
               "slug":"http://yourdomain.com/hotels/turkey/istanbul/Tria-Hotel-Istanbul-Special",
               "thumbnail":"http://yourdomain.com/uploads/images/hotels/slider/thumbs/2198_11.jpg",
               "starsCount":"5",
               "location":"Istanbul",
               "desc":"The Hotel Tria Istanbul is an intimate, style hotel, elegantly decorated and recently opened in Sultanahmet, boasting views of the Marmara Sea and the Asian Side. Crafted from a traditional Ottoman edifice, its wooden facade reflects the nobility and charm of historical Istanbul, whilst its deluxe and standard rooms are comfortably furnished with modern amenities. This special class hotel is a short walk from the most significant monuments of ancient imperial Byzantium, such as the splendid Hagia Sophia, Hippodrome and Basilica Cistern, as well as Ottoman masterpieces like Topkapi Palace and the Blue Mosque.",
               "price":"35",
               "currCode":"USD",
               "currSymbol":"$",
               "amenities":[
                  {
                     "icon":"http://yourdomain.com/uploads/images/hotels/amenities/522827_airport.png",
                     "name":"Airport Transport"
                  },
                  {
                     "icon":"http://yourdomain.com/uploads/images/hotels/amenities/593292_receptionist.png",
                     "name":"Business Center"
                  },
                  {
                     "icon":"http://yourdomain.com/uploads/images/hotels/amenities/920288_wheelchar.png",
                     "name":"Disabled Facilities"
                  },
                  {
                     "icon":"http://yourdomain.com/uploads/images/hotels/amenities/78888_club.png",
                     "name":"Night Club"
                  }
               ],
               "avgReviews":{
                  "clean":7.3,
                  "comfort":7.2,
                  "location":9.2,
                  "facilities":8.2,
                  "staff":8.3,
                  "totalReviews":"6",
                  "overall":8
               },
               "latitude":"41.0082376",
               "longitude":"28.97835889999999"
            }
         ],
         "error":{
            "status":false,
            "msg":""
         },
         "totalPages":1
      }
    </pre>
        <h4>  - Autosuggests for Hotels and Locations </h4>
        <p><strong><span class="text-primary">GET</span> : <?php echo base_url(); ?>api/hotels/suggestions?appKey=<?php echo $apikey; ?></strong></p>
        <p>Parameter 1: appKey => Your App Key</p>
        <p>Parameter 2: query => search Location/hotel (eg: istanbul)</p>
        <p><strong class="text-danger">Response</strong></p>
        <pre>
{
     "response":[
        {
           "id":"28",
           "name":"Alzer Hotel Istanbul",
           "module":"hotel",
           "disabled":false
        },
        {
           "id":"29",
           "name":"Tria Hotel Istanbul Special",
           "module":"hotel",
           "disabled":false
        },
        {
           "id":"10",
           "name":"Istanbul",
           "module":"location",
           "disabled":false
        }
     ],
     "error":{
        "status":false,
        "msg":""
     }
  }
   </pre>
        <h4>  - Hotels Search </h4>
        <p><strong><span class="text-primary">GET</span> : <?php echo base_url(); ?>api/hotels/search?appKey=<?php echo $apikey; ?></strong></p>
        <p>Parameter 1: appKey => Your App Key</p>
        <p>Parameter 2: checkin => Check-In Date (MM/DD/YYYY)</p>
        <p>Parameter 3: checkout => Check-Out Date (MM/DD/YYYY)</p>
        <p>Parameter 4: searching => Location ID</p>
        <p><strong class="text-danger">Response</strong></p>
        <pre>
   {
   "response":[
   {
    "id":"29",
    "title":"Tria Hotel Istanbul Special",
    "slug":"http://yourdomain.com/hotels/turkey/istanbul/Tria-Hotel-Istanbul-Special",
    "thumbnail":"http://yourdomain.com/uploads/images/hotels/slider/thumbs/2198_11.jpg",
    "starsCount":"5",
    "location":"Istanbul",
    "desc":"The Hotel Tria Istanbul is an intimate, style hotel, elegantly decorated and recently opened in Sultanahmet, boasting views of the Marmara Sea and the Asian Side. Crafted from a traditional Ottoman edifice, its wooden facade reflects the nobility and charm of historical Istanbul, whilst its deluxe and standard rooms are comfortably furnished with modern amenities. This special class hotel is a short walk from the most significant monuments of ancient imperial Byzantium, such as the splendid Hagia Sophia, Hippodrome and Basilica Cistern, as well as Ottoman masterpieces like Topkapi Palace and the Blue Mosque.",
    "price":"35",
    "currCode":"USD",
    "currSymbol":"$",
    "amenities":[
       {
          "icon":"http://yourdomain.com/uploads/images/hotels/amenities/522827_airport.png",
          "name":"Airport Transport"
       },
       {
          "icon":"http://yourdomain.com/uploads/images/hotels/amenities/593292_receptionist.png",
          "name":"Business Center"
       },
       {
          "icon":"http://yourdomain.com/uploads/images/hotels/amenities/920288_wheelchar.png",
          "name":"Disabled Facilities"
       },
       {
          "icon":"http://yourdomain.com/uploads/images/hotels/amenities/78888_club.png",
          "name":"Night Club"
       }
    ],
    "avgReviews":{
       "clean":7.3,
       "comfort":7.2,
       "location":9.2,
       "facilities":8.2,
       "staff":8.3,
       "totalReviews":"6",
       "overall":8
    },
    "latitude":"41.0082376",
    "longitude":"28.97835889999999"
   }
   ],
   "error":{
   "status":false,
   "msg":""
   },
   "totalPages":1
   }
   </pre>
        <h4>  - Get Hotel Details </h4>
        <p><strong><span class="text-primary">GET</span> : <?php echo base_url(); ?>api/hotels/hoteldetails?appKey=<?php echo $apikey; ?>&id=HOTEL_ID</strong></p>
        <p>Parameter 1: appKey => Your App Key</p>
        <p>Parameter 2: id => Hotel ID</p>
        <p><strong class="text-danger">Response</strong></p>
        <pre>

{
 "response": {
   "hotel": {
     "id": "40",
     "title": "Rendezvous Hotels",
     "thumbnail": "http://yourdomain.com/uploads/images/hotels/slider/thumbs/75043_1.jpg",
     "starsCount": "2",
     "location": "Singapore",
     "desc": "Rendezvous Hotel Singapore is located in the Arts and Heritage District, within 3 km (0.2 mi) of the Singapore National Museum, Singapore Art Museum, and Singapore Management University. The Dhoby Ghaut MRT (Mass Rapid Transit) station is a five-minute walk, and Orchard Road shops are a 10-to-15-minute walk. Hotel Features. The exterior of the building combines history and sophistication, while the interior offers an art-infused experience and a unique aesthetic. The hotel offers an outdoor pool, and a fitness center. Public areas and all guestrooms are nonsmoking. Straits Cafe@Rendezvous offers buffet and a la carte dining. Room service is available around the clock. A lobby bar and a gourmet food court are also on site. The hotel offers a concierge desk, a multilingual staff, and business services. Guestrooms. The air-conditioned guestrooms feature cable TV, pay movies, and in-room safes. Wireless and wired high-speed Internet access are available for a surcharge. Minibars and coffee/tea makers are also included. Bathrooms offer shower/tub combinations, handheld showers, and telephones. Wake-up calls are provided upon request",
     "amenities": [
       {
         "icon": "http://yourdomain.com/uploads/images/hotels/amenities/522827_airport.png",
         "name": "Airport Transport"
       },
       {
         "icon": "http://yourdomain.com/uploads/images/hotels/amenities/593292_receptionist.png",
         "name": "Business Center"
       },
       {
         "icon": "http://yourdomain.com/uploads/images/hotels/amenities/920288_wheelchar.png",
         "name": "Disabled Facilities"
       },
       {
         "icon": "http://yourdomain.com/uploads/images/hotels/amenities/78888_club.png",
         "name": "Night Club"
       },
       {
         "icon": "http://yourdomain.com/uploads/images/hotels/amenities/813018_laundry.png",
         "name": "Laundry Service"
       },
       {
         "icon": "http://yourdomain.com/uploads/images/hotels/amenities/53193_858245_wifi.png",
         "name": "Wi-Fi Internet"
       },
       {
         "icon": "http://yourdomain.com/uploads/images/hotels/amenities/906341_bar.png",
         "name": "Bar Lounge"
       },
       {
         "icon": "http://yourdomain.com/uploads/images/hotels/amenities/926605_811401_poll.png",
         "name": "Swimming Pool"
       },
       {
         "icon": "http://yourdomain.com/uploads/images/hotels/amenities/6348_541779_parking.png",
         "name": "Inside Parking"
       },
       {
         "icon": "http://yourdomain.com/uploads/images/hotels/amenities/117737_653168_busstation.png",
         "name": "Shuttle Bus Service"
       },
       {
         "icon": "http://yourdomain.com/uploads/images/hotels/amenities/403809_764557_fitness.png",
         "name": "Fitness Center"
       },
       {
         "icon": "http://yourdomain.com/uploads/images/hotels/amenities/308869_654419_spa.png",
         "name": "SPA"
       },
       {
         "icon": "http://yourdomain.com/uploads/images/hotels/amenities/124634_ac.png",
         "name": "Air Conditioner"
       },
       {
         "icon": "http://yourdomain.com/uploads/images/hotels/amenities/524780_card.png",
         "name": "Cards Accepted"
       },
       {
         "icon": "http://yourdomain.com/uploads/images/hotels/amenities/999481_elevator.png",
         "name": "Elevator"
       },
       {
         "icon": "http://yourdomain.com/uploads/images/hotels/amenities/179352_pet.png",
         "name": "Pets Allowed"
       }
     ],
     "latitude": "1.354313975537631",
     "longitude": "103.81743274072267",
     "sliderImages": [
       {
         "fullImage": "http://yourdomain.com/uploads/images/hotels/slider/75043_1.jpg",
         "thumbImage": "http://yourdomain.com/uploads/images/hotels/slider/thumbs/75043_1.jpg"
       },
       {
         "fullImage": "http://yourdomain.com/uploads/images/hotels/slider/2.jpg",
         "thumbImage": "http://yourdomain.com/uploads/images/hotels/slider/thumbs/2.jpg"
       },
       {
         "fullImage": "http://yourdomain.com/uploads/images/hotels/slider/3.jpg",
         "thumbImage": "http://yourdomain.com/uploads/images/hotels/slider/thumbs/3.jpg"
       },
       {
         "fullImage": "http://yourdomain.com/uploads/images/hotels/slider/4.jpg",
         "thumbImage": "http://yourdomain.com/uploads/images/hotels/slider/thumbs/4.jpg"
       },
       {
         "fullImage": "http://yourdomain.com/uploads/images/hotels/slider/5.jpg",
         "thumbImage": "http://yourdomain.com/uploads/images/hotels/slider/thumbs/5.jpg"
       },
       {
         "fullImage": "http://yourdomain.com/uploads/images/hotels/slider/6.jpg",
         "thumbImage": "http://yourdomain.com/uploads/images/hotels/slider/thumbs/6.jpg"
       },
       {
         "fullImage": "http://yourdomain.com/uploads/images/hotels/slider/7.jpg",
         "thumbImage": "http://yourdomain.com/uploads/images/hotels/slider/thumbs/7.jpg"
       },
       {
         "fullImage": "http://yourdomain.com/uploads/images/hotels/slider/8.jpg",
         "thumbImage": "http://yourdomain.com/uploads/images/hotels/slider/thumbs/8.jpg"
       },
       {
         "fullImage": "http://yourdomain.com/uploads/images/hotels/slider/9.jpg",
         "thumbImage": "http://yourdomain.com/uploads/images/hotels/slider/thumbs/9.jpg"
       },
       {
         "fullImage": "http://yourdomain.com/uploads/images/hotels/slider/10.jpg",
         "thumbImage": "http://yourdomain.com/uploads/images/hotels/slider/thumbs/10.jpg"
       },
       {
         "fullImage": "http://yourdomain.com/uploads/images/hotels/slider/11.jpg",
         "thumbImage": "http://yourdomain.com/uploads/images/hotels/slider/thumbs/11.jpg"
       },
       {
         "fullImage": "http://yourdomain.com/uploads/images/hotels/slider/2.jpg",
         "thumbImage": "http://yourdomain.com/uploads/images/hotels/slider/thumbs/2.jpg"
       },
       {
         "fullImage": "http://yourdomain.com/uploads/images/hotels/slider/12.jpg",
         "thumbImage": "http://yourdomain.com/uploads/images/hotels/slider/thumbs/12.jpg"
       }
     ],
     "relatedItems": [
       {
         "id": "30",
         "title": "Grand Plaza Apartments",
         "desc": "<p>These luxurious, stylish apartments are situated just a 5-minute walk from Hyde Park and Notting Hill. Each apartment offers free Wi-Fi, modern, open-plan kitchens and laundry facilities. All of Grand Plaza Serviced Apartments feature a living area with large, comfortable sofas, flat-screen satellite TV/DVD players, and a dining area. Each modern kitchen area is fully equipped with amenities, including a fridge, a hob, and a microwave. Some apartments include an electric oven. There is also a breakfast room on site. Bathrooms offer contemporary, tiled decor with showers/baths, and luxury washbowls and toiletries. Bayswater Tube Station and Whiteley&rsquo;s shopping centre are less than 5 minutes&#39; walk from Grand Plaza Serviced Apartments. Paddington Train Station and Portobello Market are 15 minutes&#39; walk away. Westfield Shopping Centre can be reached in 15 minutes by Tube. We speak your language! Apartments: 198</p>",
         "slug": "http://yourdomain.com/hotels/united-kingdom/london/Grand-Plaza-Apartments?&checkin=25/10/2016&checkout=26/10/2016&adults=2&child=0",
         "thumbnail": "http://yourdomain.com/uploads/images/hotels/slider/thumbs/450256_9.jpg",
         "location": "London",
         "price": "35",
         "currCode": "USD",
         "currSymbol": "$",
         "avgReviews": {
           "clean": 7.7,
           "comfort": 7.7,
           "location": 5,
           "facilities": 6.9,
           "staff": 7.7,
           "totalReviews": "7",
           "overall": 7
         },
         "latitude": "42.60948519999999",
         "longitude": "-83.95387920000002"
       },
       {
         "id": "31",
         "title": "Madinah Moevenpick Hotel",
         "desc": "<p>This luxury hotel features 3 restaurants. Guests are served a complimentary breakfast each morning. Complimentary wireless and wired high-speed Internet access is available in public areas and a computer station is located on site. This 5-star hotel features business amenities including a 24-hour business center and small meeting rooms. The staff can provide concierge services, wedding services, and tour assistance. Additional amenities include multilingual staff, gift shops/news stands, and laundry facilities. Onsite parking is complimentary.</p>",
         "slug": "http://yourdomain.com/hotels/saudi-arabia/madinah/Madinah-Moevenpick-Hotel?&checkin=25/10/2016&checkout=26/10/2016&adults=2&child=0",
         "thumbnail": "http://yourdomain.com/uploads/images/hotels/slider/thumbs/603302_10.jpg",
         "location": "Madinah",
         "price": "57",
         "currCode": "USD",
         "currSymbol": "$",
         "avgReviews": {
           "clean": 6.6,
           "comfort": 5.8,
           "location": 8.6,
           "facilities": 5.6,
           "staff": 7.8,
           "totalReviews": "9",
           "overall": 6.8
         },
         "latitude": "24.5246542",
         "longitude": "39.56918410000003"
       },
       {
         "id": "32",
         "title": "Jumeirah Beach Hotel",
         "desc": "<p>UMEIRAH BEACH HOTEL - PREMIUM FAMILY LIFESTYLE DESTINATION With its striking wave-like design, Jumeirah Beach Hotel&#39;s five-star resort is one of Dubai&rsquo;s most instantly recognisable structures. Happily for our guests, the Jumeirah Beach Hotel in Dubai is equally famed for its amazing value and sheer wealth of options to enjoying your stay. All the hotel&rsquo;s 617 rooms, suites and villas are luxuriously furnished and provide spectacular views of the Arabian Gulf. And once you&rsquo;ve finished taking in the view, you can choose from the widest array of leisure facilities around one of the best family hotels in Dubai, including a scuba diving centre, five swimming pools, Sinbad&rsquo;s Kids Club, The Hub for teens and complimentary, unlimited access to the Wild Wadi Water Park. You&rsquo;ll find everything you&rsquo;re looking for and much more at Jumeirah Beach Hotel in Dubai.</p>",
         "slug": "http://yourdomain.com/hotels/united-arab-emirates/dubai/Jumeirah-Beach-Hotel?&checkin=25/10/2016&checkout=26/10/2016&adults=2&child=0",
         "thumbnail": "http://yourdomain.com/uploads/images/hotels/slider/thumbs/731415_8.jpg",
         "location": "Dubai ",
         "price": "22",
         "currCode": "USD",
         "currSymbol": "$",
         "avgReviews": {
           "clean": 7.2,
           "comfort": 7.4,
           "location": 7.2,
           "facilities": 7.2,
           "staff": 8.2,
           "totalReviews": "5",
           "overall": 7.4
         },
         "latitude": "25.1417633",
         "longitude": "55.190799200000015"
       },
       {
         "id": "36",
         "title": "Rose Rayhaan Rotana",
         "desc": "<p>Occupying the world&rsquo;s second tallest hotel, the Rose Rayhaan by Rotana offers convenient accommodation surrounded by several restaurants and caf&eacute;s. Financial Centre Metro Station is 2 minutes&#39; walk. Rose Rayhaan is a 333-metre tall, 72-storey building providing a variety of modern, spacious rooms and suites that include LCD TVs and feature stunning city views. Rose Rayhaan&rsquo;s swimming pool is situated on the 4th floor of the hotel. Other facilities include a hot tub, massage rooms, sauna and steam rooms. The largest shopping centre in the world, Dubai Mall, is 1.5 km from this alcohol-free hotel. Dubai Exhibition Centre, the Mall of the Emirates and the Burjuman Shopping Mall are also within a 10 minute drive from the property. We speak your language! Hotel Rooms: 462, Hotel Chain: Rotana.</p>",
         "slug": "http://yourdomain.com/hotels/united-arab-emirates/dubai/Rose-Rayhaan-Rotana?&checkin=25/10/2016&checkout=26/10/2016&adults=2&child=0",
         "thumbnail": "http://yourdomain.com/uploads/images/hotels/slider/thumbs/596771_5.jpg",
         "location": "Dubai ",
         "price": "80",
         "currCode": "USD",
         "currSymbol": "$",
         "avgReviews": {
           "clean": 4.2,
           "comfort": 5.4,
           "location": 6.8,
           "facilities": 4.6,
           "staff": 7,
           "totalReviews": "5",
           "overall": 5.6
         },
         "latitude": "25.211667",
         "longitude": "55.276388999999995"
       },
       {
         "id": "37",
         "title": "Islamabad Marriott Hotel",
         "desc": "<p>The 5-star Islamabad Marriott Hotel provides high speed wireless internet, an indoor pool and a fitness centre. Pampering spa treatments with separate male and female lounges are also available. Room service is provided 24 hours. The modern air-conditioned rooms are all equipped with a 42-inch flat-screen TV, a personal safe and tea/coffee making facilities. En suite bathrooms come with hot-water showers, bathrobes and free toiletries. Islamabad Marriott Hotel is about 20 km from both Islamabad Airport and Rawalpindi Station. Daewoo Bus Station is 25 km away. On-site parking and valet parking are free. Guests can visit the beauty salon, browse the on-site bookstore, or rent cars to explore the area. The hotel also provides a florist, daily newspapers and a tour desk. Continental buffet spreads are offered at Nadia, while Chinese cuisine is served at Dynasty. Other dining options include The Royal Elephant Thai restaurant, Jason&#39;s Steak House, Dumpukht Mughlai Restaurant and Sakura Japanes</p>",
         "slug": "http://yourdomain.com/hotels/pakistan/islamabad/Islamabad-Marriott-Hotel?&checkin=25/10/2016&checkout=26/10/2016&adults=2&child=0",
         "thumbnail": "http://yourdomain.com/uploads/images/hotels/slider/thumbs/94178_4.jpg",
         "location": "Islamabad",
         "price": "100",
         "currCode": "USD",
         "currSymbol": "$",
         "avgReviews": {
           "clean": 5.3,
           "comfort": 6,
           "location": 5,
           "facilities": 6.3,
           "staff": 5.5,
           "totalReviews": "4",
           "overall": 5.6
         },
         "latitude": "33.7293882",
         "longitude": "73.09314610000001"
       },
       {
         "id": "38",
         "title": "Hyatt Regency Perth",
         "desc": "<p>This 5-star luxury hotel offers a 25-metre heated pool and a tennis court minutes from the banks of Swan River and Perth&rsquo;s city centre. A free city shuttle bus is provided. Hyatt Regency Perth Hotel provides large rooms that with views of the river or the city. Some rooms include free access the hotel&rsquo;s fitness centre and sauna. Guests can enjoy superb cuisine at any of the 5 dining outlets at the property including Cafe Restaurant, Joe&rsquo;s Oriental Diner with its spectacular open kitchen or the sumptuous Conservatory Lounge. Hyatt Regency Perth is 20 minutes&#39; drive from Perth international and Domestic Airport.</p>",
         "slug": "http://yourdomain.com/hotels/united-arab-emirates/dubai/Hyatt-Regency-Perth?&checkin=25/10/2016&checkout=26/10/2016&adults=2&child=0",
         "thumbnail": "http://yourdomain.com/uploads/images/hotels/slider/thumbs/637176_3.jpg",
         "location": "Dubai ",
         "price": "150",
         "currCode": "USD",
         "currSymbol": "$",
         "avgReviews": {
           "clean": 4,
           "comfort": 2.8,
           "location": 8.3,
           "facilities": 8.3,
           "staff": 8.3,
           "totalReviews": "4",
           "overall": 6.3
         },
         "latitude": "-31.95819269999999",
         "longitude": "115.86670630000003"
       }
     ],
     "paymentOptions": [
       {
         "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
         "name": "Credit Card"
       },
       {
         "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
         "name": "Wire Transfer"
       },
       {
         "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
         "name": "American Express"
       },
       {
         "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
         "name": "Master/ Visa Card"
       }
     ],
     "defcheckin": "12:00 PM",
     "defcheckout": "12:00 PM",
     "metadesc": "Located in Singapore's Arts and Heritage District, the art-inspired Rendezvous Hotel Singapore is 5-minute walk from Dhoby Ghaut and Bras Basah MRT...",
     "keywords": "Rendezvous Hotel Singapore by Far East Hospitality, Singapore, Singapore, hotel, Hotels",
     "policy": "Room service, Car hire, 24-hour front desk, Express check-in/check-out, Currency exchange, Ticket service, Luggage storage, Concierge service, Babysitting/child services, Laundry, Dry cleaning, Ironing service, Meeting/banquet facilities, Business centre, Fax/photocopying, VIP room facilities",
     "tripadvisorid": "299606",
     "mapAddress": "Rendezvous Hotel Singapore by Far East Hospitality Singapore"
   },
   "rooms": [
     {
       "id": "52",
       "title": "Junior Suites",
       "desc": "<p>This is Junior Suite having&nbsp;1 king bed or 2 twin beds with linen duvets. Located on top 2 floors with expansive city views, this room comes in one of three designs. 26&ndash;29 square meters (322 square feet). Minibar, coffee/tea maker. LCD TV with pay movies. iPod docking station. Wireless and wired high-speed Internet access (surcharge). Free local calls. Choice of newspapers. Bathroom with hair dryer, designer toiletries, and upgraded amenities. Terry-cloth bathrobes and bedroom slippers. Non-smoking. Welcome fruit basket upon arrival. Private check-in at Club Rendezvous. Complimentary breakfast. 20-percent discount on dry cleaning/laundry services.</p>\r\n",
       "maxAdults": "4",
       "maxChild": "3",
       "maxQuantity": 3,
       "thumbnail": "http://yourdomain.com/uploads/images/hotels/rooms/thumbs/1.jpg",
       "Images": [
         {
           "fullImage": "http://yourdomain.com/uploads/images/hotels/rooms/photos/4.jpg",
           "thumbImage": "http://yourdomain.com/uploads/images/hotels/rooms/thumbs/4.jpg"
         },
         {
           "fullImage": "http://yourdomain.com/uploads/images/hotels/rooms/photos/3.jpg",
           "thumbImage": "http://yourdomain.com/uploads/images/hotels/rooms/thumbs/3.jpg"
         },
         {
           "fullImage": "http://yourdomain.com/uploads/images/hotels/rooms/photos/2.jpg",
           "thumbImage": "http://yourdomain.com/uploads/images/hotels/rooms/thumbs/2.jpg"
         },
         {
           "fullImage": "http://yourdomain.com/uploads/images/hotels/rooms/photos/1.jpg",
           "thumbImage": "http://yourdomain.com/uploads/images/hotels/rooms/thumbs/1.jpg"
         }
       ],
       "Amenities": [
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Access via exterior corridors"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Bathroom phone"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Climate control"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Courtyard view"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Extra towels/bedding"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Hair dryer"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Makeup/shaving mirror"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Refrigerator"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Shower/tub combination"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Air conditioning"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Free Wi-Fi"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Individually furnished"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Iron/ironing board (on request)"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Minibar"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Satellite TV service"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Slippers"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "City view"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Daily housekeeping"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "LCD TV"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Private bathroom"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Wake-up calls"
         }
       ],
       "price": "1,350",
       "currCode": "USD",
       "currSymbol": "$",
       "Info": {
         "roomID": "52",
         "perNight": 1350,
         "stay": 1,
         "totalPrice": 1350,
         "checkin": "2016-10-25",
         "checkout": "2016-10-26",
         "extrabed": 55,
         "maxAdults": "4",
         "maxChild": "3",
         "quantity": "3"
       },
       "extraBeds": "5",
       "extrabedCharges": 55
     },
     {
       "id": "51",
       "title": "Superior Double",
       "desc": "<p>1 king bed or 2 twin beds with linen duvets. Located on top 2 floors with expansive city views, this room comes in one of three designs. 26&ndash;29 square meters (322 square feet). Minibar, coffee/tea maker. LCD TV with pay movies. iPod docking station. Wireless and wired high-speed Internet access (surcharge). Free local calls. Choice of newspapers. Bathroom with hair dryer, designer toiletries, and upgraded amenities. Terry-cloth bathrobes and bedroom slippers. Non-smoking. Welcome fruit basket upon arrival. Private check-in at Club Rendezvous. Complimentary breakfast. 20-percent discount on dry cleaning/laundry services.</p>\r\n",
       "maxAdults": "4",
       "maxChild": "2",
       "maxQuantity": 3,
       "thumbnail": "http://yourdomain.com/uploads/images/hotels/rooms/thumbs/2.jpg",
       "Images": [
         {
           "fullImage": "http://yourdomain.com/uploads/images/hotels/rooms/photos/1.jpg",
           "thumbImage": "http://yourdomain.com/uploads/images/hotels/rooms/thumbs/1.jpg"
         },
         {
           "fullImage": "http://yourdomain.com/uploads/images/hotels/rooms/photos/2.jpg",
           "thumbImage": "http://yourdomain.com/uploads/images/hotels/rooms/thumbs/2.jpg"
         },
         {
           "fullImage": "http://yourdomain.com/uploads/images/hotels/rooms/photos/3.jpg",
           "thumbImage": "http://yourdomain.com/uploads/images/hotels/rooms/thumbs/3.jpg"
         },
         {
           "fullImage": "http://yourdomain.com/uploads/images/hotels/rooms/photos/4.jpg",
           "thumbImage": "http://yourdomain.com/uploads/images/hotels/rooms/thumbs/4.jpg"
         }
       ],
       "Amenities": [
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Bathroom phone"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Climate control"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Courtyard view"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Extra towels/bedding"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Hair dryer"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Makeup/shaving mirror"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Refrigerator"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Shower/tub combination"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Air conditioning"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Free Wi-Fi"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Individually furnished"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Iron/ironing board (on request)"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Minibar"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Satellite TV service"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Slippers"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "City view"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Daily housekeeping"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "LCD TV"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Private bathroom"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Wake-up calls"
         }
       ],
       "price": "1,250",
       "currCode": "USD",
       "currSymbol": "$",
       "Info": {
         "roomID": "51",
         "perNight": 1250,
         "stay": 1,
         "totalPrice": 1250,
         "checkin": "2016-10-25",
         "checkout": "2016-10-26",
         "extrabed": 10,
         "maxAdults": "4",
         "maxChild": "2",
         "quantity": "3"
       },
       "extraBeds": "1",
       "extrabedCharges": 10
     },
     {
       "id": "50",
       "title": "One-Bedroom Apartment",
       "desc": "<p>1 queen bed or 2 single beds. 26-29 square meters. Desk. Television with satellite channels and pay movies. Wireless and wired high-speed Internet access (surcharge). In-room safe. Complimentary newspapers. Minibar. Shower with handheld showerhead. Bath amenities include phone, hair dryer, and complimentary toiletries. Clock radio, iron/ironing board, and sewing kit. Air conditioning. Non-smoking.</p>\r\n",
       "maxAdults": "3",
       "maxChild": "2",
       "maxQuantity": 4,
       "thumbnail": "http://yourdomain.com/uploads/images/hotels/rooms/thumbs/3.jpg",
       "Images": [
         {
           "fullImage": "http://yourdomain.com/uploads/images/hotels/rooms/photos/4.jpg",
           "thumbImage": "http://yourdomain.com/uploads/images/hotels/rooms/thumbs/4.jpg"
         },
         {
           "fullImage": "http://yourdomain.com/uploads/images/hotels/rooms/photos/3.jpg",
           "thumbImage": "http://yourdomain.com/uploads/images/hotels/rooms/thumbs/3.jpg"
         },
         {
           "fullImage": "http://yourdomain.com/uploads/images/hotels/rooms/photos/2.jpg",
           "thumbImage": "http://yourdomain.com/uploads/images/hotels/rooms/thumbs/2.jpg"
         },
         {
           "fullImage": "http://yourdomain.com/uploads/images/hotels/rooms/photos/1.jpg",
           "thumbImage": "http://yourdomain.com/uploads/images/hotels/rooms/thumbs/1.jpg"
         }
       ],
       "Amenities": [
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Bathroom phone"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Climate control"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Courtyard view"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Extra towels/bedding"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Hair dryer"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Makeup/shaving mirror"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Refrigerator"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Shower/tub combination"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Air conditioning"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Free Wi-Fi"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Individually furnished"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Iron/ironing board (on request)"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Minibar"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Satellite TV service"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Slippers"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "City view"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Daily housekeeping"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "LCD TV"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Private bathroom"
         },
         {
           "icon": "http://yourdomain.com/uploads/images/hotels/amenities/",
           "name": "Wake-up calls"
         }
       ],
       "price": "1,450",
       "currCode": "USD",
       "currSymbol": "$",
       "Info": {
         "roomID": "50",
         "perNight": 1450,
         "stay": 1,
         "totalPrice": 1450,
         "checkin": "2016-10-25",
         "checkout": "2016-10-26",
         "extrabed": 0,
         "maxAdults": "3",
         "maxChild": "2",
         "quantity": "4"
       },
       "extraBeds": "0",
       "extrabedCharges": 0
     }
   ],
   "tripadvisorinfo": "",
   "reviews": [
     {
       "review_overall": "6",
       "review_name": "Beano",
       "review_comment": "This was my 2nd stay at Rendezvous. Obviouslyl I like it or I wouldn't go back. BUT, the price is a big reason why I choose this place. There are much nicer, more modern hotels in Singapore, but this hotel is convenient to MRT and Bugis, has comfy, well-appointed rooms and very good service. The gym is the worst feature - the renovation obviously did",
       "review_date": "04/05/2014",
       "maxRating": 10
     },
     {
       "review_overall": "6.4",
       "review_name": "ambahall",
       "review_comment": "My clients Professor and Mrs Ell stayed one night at this hotel. Professor Ell lodged his visa debit card for security. A visa debit card is - or should be - internationally recognised. Certainly he could use his card for shop purchases in Singapore without a problem - there was more than sufficient money in his account. However, the Rendezvous could",
       "review_date": "04/05/2014",
       "maxRating": 10
     },
     {
       "review_overall": "4.8",
       "review_name": "Tariq Malik",
       "review_comment": "I stay here for 3 nights in Feb2014, the hotel location is ideal - close to the financial DIST and shopping street Orchid, close by to two MRT stations Basha and Dhobighat. Rooms and service is excellent , at the moment construction of MRT is taking to the adjacent land , which may noisy during the day , during the night sleep no trouble at all.",
       "review_date": "04/05/2014",
       "maxRating": 10
     }
   ],
   "avgReviews": {
     "clean": 2.7,
     "comfort": 6.3,
     "location": 7.7,
     "facilities": 6.7,
     "staff": 5.3,
     "totalReviews": "3",
     "overall": 5.7
   }
 },
 "error": {
   "status": false,
   "msg": ""
 }
}
   </pre>
        <h4>  - Book Hotel </h4>
        <p><strong><span class="text-primary">POST</span> : <?php echo base_url(); ?>api/hotels/invoice?appKey=<?php echo $apikey; ?></strong></p>
        <p>Parameter 1: userId => User id of User if logged in (Option - Integer)</p>
        <p>Parameter 2: itemid => Hotel ID </p>
        <p>Parameter 3: subitemid => Room ID </p>
        <p>Parameter 4: roomscount => No. of Rooms </p>
        <p>Parameter 5: checkin => Check-In Date </p>
        <p>Parameter 6: checkout => Check-Out Date </p>
        <p>Parameter 7: btype => hotels (Its value must be according to module - Current 'hotels' should be used)</p>
        <p>Parameter 8: extras => Extras (Array of IDs) </p>
        <p><strong class="text-danger">Response</strong>: <?php echo $invoiceIframeUrl; ?></p>
        <pre>
{
    "response":
       {
          "error":"no",
          "msg":"",
          "url":"http://yourdomain.com/invoice"
       }
 }
  </pre>
      </div>
    </div>
  </div>
  <!-- End Hotels -->
</div>
<?php } ?>

<?php if($error){ ?>
<br>
<div class="container">
<div class="alert alert-danger"> Invalid API Key </div>
</div>
<?php } ?>