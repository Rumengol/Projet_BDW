function showCommentForm(postId) {
  console.log("script atteint");
  var post = document.getElementById(`post_${postId}`);
  var comment = document.createElement("div");
  comment.setAttribute("class", "commentForm");
  comment.innerHTML = document.getElementById("commentBlock").innerHTML;
  post.appendChild(comment);
}
