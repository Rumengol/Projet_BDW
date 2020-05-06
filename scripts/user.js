function sendFriendRequest(ami1, ami2) {
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    console.log(xmlhttp.status);
    if (xmlhttp.readyState == XMLHttpRequest.DONE) {
      // XMLHttpRequest.DONE == 4
      if (xmlhttp.status == 200) {
        var addBtn = document.getElementsByClassName("addFriendButton");
        addBtn.className += " disabled";
        var addDiv = document.getElementById("addfriend");
        addDiv.innerHTML += `<a href='#' class='unfriend' onclick='unfriend("${ami1}","${ami2}")'><i class='fas fa-times'></i></a>`;
      } else if (xmlhttp.status == 400) {
        alert("There was an error 400");
      } else {
        alert("something else other than 200 was returned");
      }
    }
  };
  xmlhttp.open("POST", "../scripts/addFriend.php", true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send(`id1=${ami1}&id2=${ami2}`);
}

function unfriend(ami1, ami2) {
  var xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == XMLHttpRequest.DONE) {
      // XMLHttpRequest.DONE == 4
      if (xmlhttp.status == 200) {
        var unbtn = document.getElementsByClassName("unfriend");
        if (unbtn) {
          var addDiv = document.getElementById("addfriend");
          addDiv.innerHTML = `<a href='#' class='addFriendButton' onclick='sendFriendRequest("${ami1}","${ami2}")'><i class='fas fa-user'></i> Ajouter ami</a>`;
        }
      } else if (xmlhttp.status == 400) {
        alert("There was an error 400");
      } else {
        alert("something else other than 200 was returned");
      }
    }
  };

  xmlhttp.open("POST", "../scripts/unfriend.php", true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send(`id1=${ami1}&id2=${ami2}`);
}
