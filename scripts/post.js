let toggle = {};

function showCommentForm(postId) {
  var post = document.getElementById(`post_${postId}`);
  var form = document.getElementById("commentBlock");
  if (form != null) {
    form.parentNode.removeChild(form);
  }
  var comment = document.createElement("div");
  comment.setAttribute("id", "commentBlock");
  comment.innerHTML = document.getElementById("commentHtml").innerHTML;
  post.appendChild(comment);
  var formpart = document.querySelector(".commentForm");
  var postRef = document.createElement("input");
  postRef.setAttribute("name", "post");
  postRef.setAttribute("value", postId);
  postRef.setAttribute("hidden", true);
  formpart.appendChild(postRef);
}

function toggleComments(postId) {
  var post = document.getElementById(`post_${postId}`);

  if (toggle[postId] == true) {
    commentContainer = document.querySelector(
      `#post_${postId} .commentContainer`
    );
    post.removeChild(commentContainer);
    toggle[postId] = false;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      console.log(xmlhttp.status);
      if (xmlhttp.readyState == XMLHttpRequest.DONE) {
        // XMLHttpRequest.DONE == 4
        if (xmlhttp.status == 200) {
          var container = document.createElement("div");
          container.setAttribute("class", "commentContainer");
          container.innerHTML = xmlhttp.responseText;
          post.appendChild(container);
          toggle[postId] = true;
        } else if (xmlhttp.status == 400) {
          alert("There was an error 400");
        } else {
          alert("something else other than 200 was returned");
        }
      }
    };
    xmlhttp.open("GET", `../scripts/showComments.php?postid=${postId}`, true);
    xmlhttp.send();
  }
}

function deleteComment(commentId) {
  var comment = document.getElementById(`comment_${commentId}`);
  var xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == XMLHttpRequest.DONE) {
      // XMLHttpRequest.DONE == 4
      if (xmlhttp.status == 200) {
        comment.parentNode.removeChild(comment);
      } else if (xmlhttp.status == 400) {
        alert("There was an error 400");
      } else {
        alert("something else other than 200 was returned");
      }
    }
  };
  xmlhttp.open("POST", "../scripts/deleteComment.php", true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send(`id=${commentId}`);
}

function deletePost(postId) {
  var post = document.getElementById(`post_${postId}`);
  var xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == XMLHttpRequest.DONE) {
      // XMLHttpRequest.DONE == 4
      if (xmlhttp.status == 200) {
        post.parentNode.removeChild(post);
      } else if (xmlhttp.status == 400) {
        alert("There was an error 400");
      } else {
        alert("something else other than 200 was returned");
      }
    }
  };
  xmlhttp.open("POST", "../scripts/supprimer.php", true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send(`id=${postId}`);
}
