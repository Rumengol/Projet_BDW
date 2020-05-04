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
}
