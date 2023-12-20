function toggleAnswer(question) {
  // Find the next sibling, which should be the corresponding answer
  var answer = question.nextElementSibling;

  // Toggle the 'display' property of the answer element
  if (answer.style.display === "block") {
    answer.style.display = "none";
  } else {
    answer.style.display = "block";
  }
}
