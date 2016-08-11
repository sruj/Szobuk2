var myUrl = Routing.generate('zmianaQuantity');

function aktualizacjaKoszyka() {
    var data = {}; 
    var quantity = document.getElementsByClassName('inputISBN');
    var cena = document.getElementsByClassName('cena');
    var razem = document.getElementsByClassName('razem');
    var suma = document.getElementById('suma');
    var quantityBasket = document.getElementById('quantityBasket');
    var licznikSuma = 0;
    var licznikQuantity = 0;
    
    for (var i = 0; i < quantity.length; i++){ 
        data[quantity[i].name] = quantity[i].value;
        razem[i].innerText = parseInt(quantity[i].value*cena[i].innerText).toFixed(2);
        licznikSuma += parseInt(razem[i].innerText);
        licznikQuantity += parseInt(quantity[i].value);
    }
    suma.innerText = licznikSuma.toFixed(2);
    quantityBasket.innerText = licznikQuantity;
    
    $.ajax({
      url: myUrl,
      type: "POST",
      data: {data:data}
    });   
}



// funkcja wysyłająca do path ' ' tablicę alfanumeryczną
// ['isbn']=>ilość. Funkcja jest wywoływana przy zdarzeniu
// onChange przy tagach input w cartmenu
