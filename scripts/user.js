function sendFriendRequest(ami1, ami2) {
  var xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == XMLHttpRequest.DONE) {
      // XMLHttpRequest.DONE == 4
      if (xmlhttp.status == 200) {
        var addBtn = document.getElementsByClassName("addFriendButton");
        if (!addBtn.disabled) addBtn.disabled = true;
      } else if (xmlhttp.status == 400) {
        alert("There was an error 400");
      } else {
        alert("something else other than 200 was returned");
      }
    }
  };

  xmlhttp.open("POST", "addFriend.php", true);
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
          addDiv.innerHTML = `<a href='#' class='addFriendButton' onclick='sendFriendRequest(".${ami1}.",".${ami2}."')><i class='fas fa-user'></i> Ajouter ami</a>`;
        }
      } else if (xmlhttp.status == 400) {
        alert("There was an error 400");
      } else {
        alert("something else other than 200 was returned");
      }
    }
  };

  xmlhttp.open("POST", "unfriend.php", true);
  xmlhttp.send(`id1=${ami1}&id2=${ami2}`);
}
