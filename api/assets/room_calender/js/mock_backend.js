$(document).ready(function() {
    console.log('hotel: '+hotel_id);
    init(hotel_id);
});

function init(_hotel){
    var d = new Date();
    scheduler.init('scheduler_here', new Date(d.getFullYear(), d.getMonth(), d.getDate()), "month_timeline");
    // scheduler.load("./data.php", "json");
    $.ajax({
        url: apiUrl+'data',
        data: {
            hotel: _hotel
        },
        success: function (result) {
            scheduler.parse(result, "json");
        }
    });
    initLightboxBgCancel();
  
    window.dp = new dataProcessor(apiUrl+'data');
    // dp.serverProcessor = apiUrl;
    dp.init(scheduler);
  
    // Error Handling
    dp.attachEvent("onAfterUpdate", function(id, action, tid, response){
        console.log('onAfterUpdate');
        dhtmlx.message({
            type: response.action,
            text: response.message
        });
        if(action == "error"){
            // do something here
            console.log('Error Occured!');
        }
    });
}
