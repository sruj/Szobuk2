var myUrl = Routing.generate('addtowishlist');

function addToWishlist(product) {

    //wsl 3. wyswietl ikonkę serduszeczka
    //wsl 3a. zaznacz element div i ustaw atrybut na visible true
    $("h1").show( "slow" );
var j = 0;
    //wsl 2. wyślij do kontrolera isbn
    $.ajax({
      url: myUrl,
      type: "POST",
      data: {data:product}
    });

}



