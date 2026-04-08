document.addEventListener("DOMContentLoaded", () => {
    const page = document.body.dataset.page;
    const navLinks = document.querySelectorAll("[data-nav]");
    const yearNodes = document.querySelectorAll("[data-year]");
    const reveals = document.querySelectorAll("[data-reveal]");
    const enquiryForm = document.querySelector("#enquiryForm");
    const statusBox = document.querySelector("#formStatus");

    navLinks.forEach((link) => {
        if (link.dataset.nav === page) {
            link.classList.add("active");
            link.setAttribute("aria-current", "page");
        }
    });

    yearNodes.forEach((node) => {
        node.textContent = new Date().getFullYear();
    });

    if (reveals.length > 0) {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("is-visible");
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.14 }
        );

        reveals.forEach((item, index) => {
            item.style.transitionDelay = `${Math.min(index * 60, 240)}ms`;
            observer.observe(item);
        });
    }

    if (enquiryForm && statusBox) {
        enquiryForm.addEventListener("submit", (event) => {
            event.preventDefault();

            if (!enquiryForm.checkValidity()) {
                event.stopPropagation();
                enquiryForm.classList.add("was-validated");
                statusBox.classList.remove("d-none", "alert-success");
                statusBox.classList.add("alert-danger");
                statusBox.textContent = "Please complete the required fields before sending your enquiry.";
                return;
            }

            enquiryForm.classList.add("was-validated");
            statusBox.classList.remove("d-none", "alert-danger");
            statusBox.classList.add("alert-success");
            statusBox.textContent = "This demo form is ready for integration. Connect it to email or PHP handling when your workflow is approved.";
            enquiryForm.reset();
            enquiryForm.classList.remove("was-validated");
        });
    }
});