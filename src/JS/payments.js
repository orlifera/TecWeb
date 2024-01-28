let processHeading = document.querySelector(".process-headings"),
  completeHeading = document.querySelector(".complete-headings"),
  progressBar = document.querySelector(".loading-bar span"),
  progressAmount = parseInt(
    document.querySelector(".loading-bar").getAttribute("data-progress"),
    10
  ),
  tick = document.querySelector(".checkmark");
progressAmount = 0;

function newHeadings() {
  processHeading.classList.remove("show");
  processHeading.classList.add("hidden");
  completeHeading.classList.remove("hidden");
  completeHeading.classList.add("show");
  tick.classList.remove("hidden");
  tick.classList.add("show");
}

function reverseAnimation() {
  let processing = document.getElementById("processing");
  processing.classList.remove("uncomplete");
  processing.classList.add("complete");
  newHeadings();
}

document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("orderBtn").addEventListener("click", function () {
    // Hide payment container and show payment animation
    document.getElementById("payment-container").classList.remove("show");
    document.getElementById("payment-container").classList.add("hidden");
    document.getElementById("processing").classList.remove("hidden");
    document.getElementById("processing").classList.add("show");

    // Start the loading animation
    setTimeout(function () {
      let interval = setInterval(function () {
        progressAmount += 10;
        // progressBar.style.width = progressAmount + '%';

        if (progressAmount >= 100) {
          setTimeout(function () {
            clearInterval(interval);
            reverseAnimation();
            setTimeout(function () {
              window.location.href = "../../index.html";
            }, 5000);
          }, 300);
        }
      }, 300);
    }, 2000);
  });
});
