document.addEventListener('DOMContentLoaded', function() { 
 var marca = document.getElementById('marca').value,
 nombreComercial = document.getElementById('nombreComercial').value,
 descripcion = document.getElementById('descripcion').value,
 detalle = document.getElementById('detalle').value,
 porcAlcohol = document.getElementById('porcAlcohol').value,
 vaCon = document.getElementById('vaCon').value,
 uva = document.getElementById('uva').value,
 cantidad = document.getElementById('cantidad').value,
 precio = document.getElementById('precio').value,
 anio = document.getElementById('anio').value,
 productoTexto = document.getElementById('productoTexto'), 
 lugardeOrigen = document.getElementById('lugardeOrigen').value,
 textoLugardeOrigen = document.getElementById('textoLugardeOrigen'), 
 tipo = document.getElementById('tipo').value,
 textoTipo = document.getElementById('textoTipo').value,
 sendButton = document.getElementById('sendButton'),
 textproductoImagen = document.getElementById('textproductoImagen'),
 textLugarOrigen = document.getElementById('textLugarOrigen'),
 textImagenTipos = document.getElementById('textImagenTipos')
 categoria = document.getElementById('categoria').value;

  var config = {
    apiKey: "AIzaSyCSmrTn8_i5xTqSGz4qSrW9ToURDmvaRzQ",
    authDomain: "restock-b5c8c.firebaseapp.com",
    databaseURL: "https://restock-b5c8c.firebaseio.com",
    projectId: "restock-b5c8c",
    storageBucket: "restock-b5c8c.appspot.com",
    messagingSenderId: "609418753795"
  };
  // Get the Firebase app and all primitives we'll use
  var app = firebase.initializeApp(config),
      database = app.database(),
      auth = app.auth(),
      storage = app.storage();



  function Product(e) {
    var file = e.target.files[0];
    var storageRef = storage.ref().child('Productos');
    var photoRef = storageRef.child(file.name);
    var uploadTask = photoRef.put(file);
    uploadTask.on('state_changed', null, null, function() {
      var downloadUrl = uploadTask.snapshot.downloadURL;
      textproductoImagen.value = downloadUrl;
    });
  }
  prodcutoImagen.addEventListener('change', Product, false);

  function Origen(i) {
    var imagenLugardeOrigen = i.target.files[0];
    var storageRef = storage.ref().child('Lugar_Origen');
    var photoRef = storageRef.child(imagenLugardeOrigen.name);
    var uploadTask = photoRef.put(imagenLugardeOrigen);
    uploadTask.on('state_changed', null, null, function() {
      var downloadURL = uploadTask.snapshot.downloadURL;
      textLugarOrigen.value = downloadURL;

    });
  }
  imagenLugardeOrigen.addEventListener('change', Origen, false);

  function Categoria(o) {
    var imagenCategoria = o.target.files[0];
    var storageRef = storage.ref().child('Categoria');
    var photoRef = storageRef.child(imagenCategoria.name);
    var uploadTask = photoRef.put(imagenCategoria);
    uploadTask.on('state_changed', null, null, function() {
      var downloadURL = uploadTask.snapshot.downloadURL;
      textImagenCategoria.value = downloadURL;
    });
  }
  imagenCategoria.addEventListener('change', Categoria, false);

   function Tipo(o) {
    var imagenTipo = o.target.files[0];
    var storageRef = storage.ref().child('Categoria');
    var photoRef = storageRef.child(imagenTipo.name);
    var uploadTask = photoRef.put(imagenTipo);
    uploadTask.on('state_changed', null, null, function() {
      var downloadURL = uploadTask.snapshot.downloadURL;
      textImagenTipo.value = downloadURL;
    });
  }
  imagenTipo.addEventListener('change', Tipo, false);

   var databaseRefOrigen = database.ref().child('Country');
   var databaseRefTipo = database.ref().child('Type');
   var databaseRefCategoria = database.ref().child('Category');
   var databaseRef = database.ref().child('Product');

  sendButton.addEventListener('click', function(evt) {
  	var pushOrigen = {
  		PlaceOfOrigin: lugardeOrigen,
  		Image: textLugarOrigen.value
	};
	var origenPush = databaseRefOrigen.push();
	var origenSet = origenPush.set(pushOrigen);
	var origenKey = origenPush.key;

	var pushCategoria = {
  		Nombre: categoria,
  		Image: textImagenCategoria.value
	};
	var categoriaPush = databaseRefCategoria.push();
	var categoriaSet = categoriaPush.set(pushCategoria);
	var categoriaKey = categoriaPush.key;


	var pushTipo = {
  		Type: tipo,
  		Imgage: textImagenTipo.value,
  		Category: categoriaKey
	};
	var tipoPush = databaseRefTipo.push();
	var tipoSet = tipoPush.set(pushTipo);
	var tipoKey = tipoPush.key;
	
  	var pushProducts = { 
  		
  		Brand: marca, 
  		Name: nombreComercial, 
  		Description: descripcion,
  		Detail: detalle,
  		GoesWith: vaCon,
  		Grape: uva,
  		AlcoholPercentage: porcAlcohol,
  		Price: precio,
  		Quantity: cantidad,
  		Year: anio,
  		PlaceOfOrigin: origenKey,
  		Type: tipoKey,
  		Image: textproductoImagen.value
  	};
    databaseRef.push().set(pushProducts);

    swal("Producto Registrado")
  	.then((value) => {
  	window.location.href = "detail.html";
});
  });


});