<?php
$obj = $_GET['obj'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Orders</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
	<meta charset="utf-8">
	<!-- CSS Styles-->
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/materialize.css">
	<link rel="stylesheet" type="text/css" href="materialize.min.css">
	<link rel="stylesheet" href="css/animate.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<!-- JQuery-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!--ViewPort -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="Assets/logo4.png">
	<style type="text/css">
		.row{
			margin-bottom: 0;
		}
		pre{
			color: black;
		}

	</style>


</head>
<body>
<div class="bg">
	  <nav>
	    <div class="nav-wrapper">
	      <img class="" src="Assets/navbar.png">
	    </div>
 	 </nav>
	 <div class="row">
		<div class="col xl10 offset-xl1 l12 m12 s12" style="margin-top: 20px;">
	 		<div id="map"></div>
		</div>
	</div>
  <div class="container-fluid">
        <div class="row">
        <div class="col x12">
          <h2>Usuario</h2>
        </div>
      </div>
          <table class="highlight centered responsive-table tableDetail">
        <thead>
          <tr>
              <th>Foto de perfil</th>
              <th>Nombre</th>
              <th>Email</th>
              <th>Numero de telefono</th>
              <th>Fecha de nacimiento</th>

          </tr>
        </thead>

        <tbody id="tabla" style="font-size: 20px;">                                
      </tbody>
      </table>   
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="col x12">
        <h2>Productos</h2>
      </div>
    </div>
          <table class="highlight centered responsive-table tableDetail">
        <thead>
          <tr>
              <th>Imagen</th>
              <th>Nombre</th>
              <th>Cantidad</th>
              <th>Detalle</th>
              <th>Precio x Unidad</th>
              <th>Precio Total</th>

          </tr>
        </thead>

        <tbody id="tableProducts" style="font-size: 20px;">                                
      </tbody>
      </table>   
  </div>
  <div class="row">
    <div class="col s12" style="margin-top: 30px; margin-bottom: 30px;">
      <a class="buttonPush waves-effect waves-light btn-large" onclick="UpdateOrder();" ><i class="material-icons right">local_shipping</i>Contestar Petición</a>
    </div>
  </div>
	<!--<pre id="Tipo"></pre>-->
</div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.12.0/firebase.js"></script>
    <script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBagTgmGCDy3-zcrn6O8Ain2Kuvpf_j-nQ&callback=initMap" async defer></script>

<script>
  //Variable generales
		var obj = "<?php echo $obj; ?>"
		var latitud;
		var longitud;
    const table = document.getElementById('tabla');
    const tableProducs = document.getElementById('tableProducts');
		var config = {
	    apiKey: "AIzaSyCSmrTn8_i5xTqSGz4qSrW9ToURDmvaRzQ",
	    authDomain: "restock-b5c8c.firebaseapp.com",
	    databaseURL: "https://restock-b5c8c.firebaseio.com",
	    projectId: "restock-b5c8c",
	    storageBucket: "restock-b5c8c.appspot.com",
	    messagingSenderId: "609418753795"
	  };
	  firebase.initializeApp(config);

  //Consulta de la base de datos
	  const dbRefObject = firebase.database().ref().child('Order/' + obj);
	  dbRefObject.once('value', snap =>{
		var lat = snap.val().Lat;
		var long = snap.val().Lng;
    var name = snap.val().User;
    var subTotal = snap.val();
    initMap(lat,long);
    tableUser(name);
	});

  
  ProductsKeys();
   //Tabla de productos
  function ProductsKeys(){
      const dbRefObject = firebase.database().ref().child('OrderContent').orderByChild('Order').equalTo(obj);
      dbRefObject.on('child_added', snap =>{
        var productKey = snap.val().Product;
        var quantity = snap.val().Quantity;
        var total = snap.val().Total;
        tablesProducts(productKey,quantity,total);
    });

   }
   //Tabla de Productos
   function tablesProducts(productKey,quantity,total){
    var product = productKey;
    var quantityProduct = quantity;
    var totalAmount = total;

    const dbRefObject = firebase.database().ref().child('Product/' + product);
    dbRefObject.on('value', snap =>{
        var prodcutImage = document.createElement('img');
        prodcutImage.src = snap.val().Image;
        prodcutImage.className = "profilePhoto";
        var row = tableProducts.insertRow(0);
        var cell0 = row.insertCell(0);
        var cell1 = row.insertCell(1);
        var cell2 = row.insertCell(2);
        var cell3 = row.insertCell(3);
        var cell4 = row.insertCell(4);
        var cell5 = row.insertCell(5);
        cell0.appendChild(prodcutImage);
        cell1.innerHTML = snap.val().Name;
        cell3.innerHTML = snap.val().Detail;
        cell2.innerHTML = quantityProduct;
        cell4.innerHTML = "$" + snap.val().Price + " MXN";
        cell5.innerHTML = "$" + totalAmount +  " MXN";
    });

   } 

  //Tabla de usuario
   function tableUser(user){
    var userKey = user;
     const dbRefObject = firebase.database().ref().child('User/' + userKey);
      dbRefObject.on('value', snap =>{
        var imageProfile = document.createElement('img');
        imageProfile.src = snap.val().ProfilePicture;
        imageProfile.className = "profilePhoto";
        var row = table.insertRow(0);
        var cell0 = row.insertCell(0);
        var cell1 = row.insertCell(1);
        var cell2 = row.insertCell(2);
        var cell3 = row.insertCell(3);
        var cell4 = row.insertCell(4);
        cell0.appendChild(imageProfile);
        cell1.innerHTML = snap.val().Name;
        cell2.innerHTML = snap.val().Email;
        cell3.innerHTML = snap.val().PhoneNumber;
        cell4.innerHTML = snap.val().DateOfBirth;

    });

   }

   //Despliega el mapa principal con estilo
	 function initMap(lat,long) {
		
		latitud = parseFloat(lat);
		longitud = parseFloat(long);
 		var myLatLng = {lat: latitud, lng: longitud};

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 12,
    center: myLatLng
  });

  var marker = new google.maps.Marker({
    position: myLatLng,
    map: map,
    title: 'Restock!',
     icon: 'https://www.google.com/mapfiles/ms/micons/purple-pushpin.png'
  });
}

//Push para el status
function UpdateOrder(){
  var nameKey;
  var name;
  var token;
  var database = firebase.database();
  firebase.database().ref('Order/' + obj).update({
    Status : "2"
  });

  const dbRefObject = firebase.database().ref().child('Order/' + obj);
    dbRefObject.once('value', snap =>{
      nameKey = snap.val().User;
      User(nameKey);
  });

  function User(key){
      const dbRefObject = firebase.database().ref().child('User/' + nameKey);
        dbRefObject.once('value', snap =>{
          name = snap.val().Name;
          token = snap.val().Token;
          SendNotiication(name,token);
      });
    }

  function SendNotiication(name,keyUser){
    var key = 'AAAAjeQwNwM:APA91bEaj_5bzZr5tjwIYSKNlGCVwsBLrcr5-EqnLfgMWnFEw4xOHpjObRUXpS_YjE8RCr5m6PhAoDgIgdyquXmw6ff0k9PDr0aoUSG9lzA32ATcXzUeWtrQgi7Yx7dPhi7jtjfPEZbV';
    var to = token ;
    console.log(token)
    var notification = {
    'title': name + ', tu orden está en camino',
    'body': 'Gracias por confiar en Restock'
    };
    fetch('https://fcm.googleapis.com/fcm/send', {
      'method': 'POST',
      'headers': {
        'Authorization': 'key=' + key,
        'Content-Type': 'application/json'
      },
      'body': JSON.stringify({
        'notification': notification,
        'to': to
      })
    }).then(function(response) {
      console.log(response);
    }).catch(function(error) {
      console.error(error);
    })
  }
  swal("Order Actualizada :)")
  .then((value) => {
  window.location.href = "detail.html";
});
}

</script>



</body>
</html>