function showAnswer(q) { 
  q.classList.remove("hidden");
  q.classList.add("show");
}

function hideAnswer(q) {
  q.classList.remove("show");
  q.classList.add("hidden");
}

function toggleAnswer(event) {
  console.log("clicked", event.currentTarget);
  var question = event.currentTarget;
  var answer = question.nextElementSibling;
  if (answer.classList.contains("show")) {
    hideAnswer(answer);
  } 
  else if (answer.classList.contains("hidden")) {
    showAnswer(answer);
  }
}

document.addEventListener('DOMContentLoaded', function () {

  document.querySelectorAll('.question').forEach(function (question) {
        question.addEventListener('click', toggleAnswer);
    });

});
