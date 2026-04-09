document.addEventListener("DOMContentLoaded", () => {
    const branchDataNode = document.getElementById("contact-branch-data");
    const branchButtons = document.querySelectorAll("[data-branch-tab]");

    if (!branchDataNode || branchButtons.length === 0) {
        return;
    }

    let branches = [];

    try {
        branches = JSON.parse(branchDataNode.textContent || "[]");
    } catch (error) {
        return;
    }

    const officeName = document.querySelector("[data-contact-office-name]");
    const officeRegistration = document.querySelector("[data-contact-office-registration]");
    const officeAddress = document.querySelector("[data-contact-office-address]");
    const contactBlocks = document.querySelector("[data-contact-blocks]");
    const whatsappCard = document.querySelector("[data-contact-whatsapp]");
    const whatsappLabel = document.querySelector("[data-contact-whatsapp-label]");
    const whatsappSubLabel = document.querySelector("[data-contact-whatsapp-sublabel]");

    const renderContactBlocks = (items) => {
        if (!contactBlocks) {
            return;
        }

        contactBlocks.innerHTML = items
            .map(
                (item) =>
                    `<div class="contact-list-item"><strong>${item.label}</strong><span>${item.value}</span></div>`
            )
            .join("");
    };

    const renderAddressLines = (lines) => {
        if (!officeAddress) {
            return;
        }

        officeAddress.innerHTML = lines
            .map((line) => `<p class="contact-address-line">${line}</p>`)
            .join("");
    };

    const activateBranch = (branchId) => {
        const branch = branches.find((item) => item.id === branchId);

        if (!branch) {
            return;
        }

        branchButtons.forEach((button) => {
            const isActive = button.dataset.branchTab === branchId;
            button.classList.toggle("is-active", isActive);
            button.setAttribute("aria-pressed", isActive ? "true" : "false");
        });

        if (officeName) {
            officeName.textContent = branch.office.name;
        }

        if (officeRegistration) {
            officeRegistration.textContent = branch.office.registration;
        }

        renderAddressLines(branch.office.addressLines || []);
        renderContactBlocks(branch.contactBlocks || []);

        if (whatsappCard) {
            whatsappCard.href = branch.whatsApp.href;
        }

        if (whatsappLabel) {
            whatsappLabel.textContent = branch.whatsApp.label;
        }

        if (whatsappSubLabel) {
            whatsappSubLabel.textContent = branch.whatsApp.subLabel;
        }
    };

    branchButtons.forEach((button) => {
        button.addEventListener("click", () => {
            activateBranch(button.dataset.branchTab || "");
        });
    });
});