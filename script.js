const enquiryForm = document.querySelector("#enquiry-form");
const formNote = document.querySelector("#form-note");

if (enquiryForm && formNote) {
    enquiryForm.addEventListener("submit", (event) => {
        event.preventDefault();

        const formData = new FormData(enquiryForm);
        const name = String(formData.get("name") || "there").trim();

        formNote.textContent = `Thanks, ${name}. Your enquiry has been captured for follow-up.`;
        enquiryForm.reset();
    });
}