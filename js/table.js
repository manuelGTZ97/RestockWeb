// Initialize Firebase
  var config = {
    apiKey: "AIzaSyCSmrTn8_i5xTqSGz4qSrW9ToURDmvaRzQ",
    authDomain: "restock-b5c8c.firebaseapp.com",
    databaseURL: "https://restock-b5c8c.firebaseio.com",
    projectId: "restock-b5c8c",
    storageBucket: "restock-b5c8c.appspot.com",
    messagingSenderId: "609418753795"
  };
  firebase.initializeApp(config);

//Variables generales
const table = document.getElementById('tabla');
var name;
table.innerHTML = "";

//Consulta a la base de datos para recuperar el key de cada orden
 const objectRef = firebase.database().ref().child('Order').orderByChild('Status').equalTo('1');
      objectRef.on('child_added', snap =>{
        user = snap.val().User;
        orderKey = snap.key;
        date = snap.val().Date;
        tableKey(user,orderKey,date);
    });
      
//Metodo que inserta en la tabla
function tableKey(user,orderKey,date){
     var userKey = user;
     var date = date;
     var total = total;
     objParent = orderKey;
      var buttonDetail = document.createElement('a');
     const dbRefObject = firebase.database().ref().child('User/' + userKey);
      dbRefObject.on('value', snap =>{
        buttonDetail.innerText = "Detalle";
        buttonDetail.className = "btn waves-effect waves-light";
        var row = table.insertRow(0);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cellButton = row.insertCell(4);
        cell1.innerHTML =snap.val().Name;
        cell2.innerHTML = snap.val().Email;
        cell3.innerHTML = snap.val().PhoneNumber;
        cell4.innerHTML = date;
        cellButton.appendChild(buttonDetail);
    });
      buttonDetail.href = "order.php?obj=" + objParent;
}