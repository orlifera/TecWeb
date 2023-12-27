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
/*document.addEventListener('DOMContentLoaded', function () {

  var questions = document.getElementsByClassName('question');

  function toggleAnswer(event) {
    
    // Find the next sibling, which should be the corresponding answer
    var answer = event.nextElementSibling;

    // // Toggle the 'display' property of the answer element
    // if (answer.style.display === "block" || answer.style.display === "") {
    //   answer.style.display = "none";
    // } else {
    //   answer.style.display = "block";
    // }
    // Check if answer is defined
    if (answer) {
      // Toggle the 'display' property of the answer element
      var answerDisplay = getComputedStyle(answer).display;
      if (answerDisplay === "block" || answerDisplay === "") {
        answer.style.display = "none";
      } else {
        answer.style.display = "block";
      }
    }
  }

  for (var i = 0; i < questions.length; i++) {
    questions[i].addEventListener('click', toggleAnswer);
  }

});
*/