document.addEventListener('DOMContentLoaded', function () {

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

// function toggleAnswer(question) {
//   // Find the next sibling, which should be the corresponding answer
//   var answer = question.nextElementSibling;

//   // Toggle the 'display' property of the answer element
//   if (answer.style.display === "block") {
//     answer.style.display = "none";
//   } else {
//     answer.style.display = "block";
//   }
// }

// document.addEventListener('DOMContentLoaded', function() {
//   const question = document.querySelector('#question');
//   question.addEventListener('click', function(event) {
//     toggleAnswer(question);
//   });
// });
