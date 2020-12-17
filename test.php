<!-- <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Google Maps GeoCoding</title>
  </head>
  <body>
    <header>
      <h1>Reverse GeoCoding with Google Maps</h1>
    </header> -->
    <!-- write some stuff about a place here -->
    <script>
      // const KEY = "AIzaSyDBEGrApnjX_7GHcNDtF0LR0pgrwxj5j2Q";
      // const LAT = 50.1;
      // const LNG = -97.3;
      // let url = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${LAT},${LNG}&key=${KEY}`;
      // fetch(url)
      //   .then(response => response.json())
      //   .then(data => {
      //     console.log(data);
      //     let parts = data.results[0].address_components;
      //     document.body.insertAdjacentHTML(
      //       "beforeend",
      //       `<p>Formatted: ${data.results[0].formatted_address}</p>`
      //     );
      //     parts.forEach(part => {
      //       if (part.types.includes("country")) {
              //we found "country" inside the data.results[0].address_components[x].types array
        //       document.body.insertAdjacentHTML(
        //         "beforeend",
        //         `<p>COUNTRY: ${part.long_name}</p>`
        //       );
        //     }
        //     if (part.types.includes("administrative_area_level_1")) {
        //       document.body.insertAdjacentHTML(
        //         "beforeend",
        //         `<p>PROVINCE: ${part.long_name}</p>`
        //       );
        //     }
        //     if (part.types.includes("administrative_area_level_3")) {
        //       document.body.insertAdjacentHTML(
        //         "beforeend",
        //         `<p>LEVEL 3: ${part.long_name}</p>`
        //       );
        //     }
        //   });
        // })
        // .catch(err => console.warn(err.message));
    </script>
  <!-- </body>
</html> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
// init();
// window.addEventListener('load', function() {

//   function updateOnlineStatus(event) {
//     var condition = navigator.onLine ? "online" : "offline";
//     if (condition == 'offline') {
        
//     }
//   }

//   window.addEventListener('online',  updateOnlineStatus);
//   window.addEventListener('offline', updateOnlineStatus);
// });

// window.onbeforeunload = function (event) {
//     var message = 'Important: Please click on \'Save\' button to leave this page.';
//     if (typeof event == 'undefined') {
//         event = window.event;
//     }
//     if (event) {
//         event.returnValue = message;
//     }
//     return message;
// };
// $.ajax({
//     url: 'test1.php',
//     success: function(response){
//     },
// });
// $(function () {
//     $("a").not('#lnkLogOut').click(function () {
//         window.onbeforeunload = null;
//     });
//     $(".btn").click(function () {
//         window.onbeforeunload = null;
// });

// };
$.ajax({
    url: 'https://wsp.smsalgerie.com/api/json?apikey=7cce8c17a01c813de3b16226ae78ff7f89de87cf&userkey=90afa0dbdb9eaba3a0655771c8714d86&function=sms_send&message=Ceci%20est%20un%20test&to=213549571913',
    // url: 'elitsms.php?id=5209823',
    type: 'GET',
    dataType: 'json',
    contentType: false,
    processData: false,
    beforeSend: function(){
    },
    success: function(response){
        console.log(response);
    },
    complete: function(){
    }
});
</script>