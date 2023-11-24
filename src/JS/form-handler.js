(function () {
  // https://dashboard.emailjs.com/admin/account
  emailjs.init("iNdbzp60ZWw2gITAZ");
})();

window.onload = function () {
  document
    .getElementById("contact-form")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      // generate a five digit number for the contact_number variable
      var contactNumberInput = document.createElement("input");
      contactNumberInput.type = "hidden";
      contactNumberInput.name = "contact_number";
      contactNumberInput.value = (Math.random() * 100000) | 0;
      this.appendChild(contactNumberInput);
      // these IDs from the previous steps
      emailjs.sendForm("service_pklquej", "template_dyacfuz", this).then(
        function () {
          console.log("SUCCESS!");
          alert("Form inviato correttamente. Vi risponderemo al più presto!");
        },
        function (error) {
          console.log("FAILED...", error);
        }
      );
    });
};
