const initContactTabs = () => {
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
    const phoneCard = document.querySelector("[data-contact-phone]");
    const phoneLabel = document.querySelector("[data-contact-phone-label]");
    const phoneValue = document.querySelector("[data-contact-phone-value]");
    const emailCard = document.querySelector("[data-contact-email]");
    const emailLabel = document.querySelector("[data-contact-email-label]");
    const emailValue = document.querySelector("[data-contact-email-value]");

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

        if (phoneCard) {
            phoneCard.href = branch.quickActions.phone.href;
        }

        if (phoneLabel) {
            phoneLabel.textContent = branch.quickActions.phone.label;
        }

        if (phoneValue) {
            phoneValue.textContent = branch.quickActions.phone.value;
        }

        if (emailCard) {
            emailCard.href = branch.quickActions.email.href;
        }

        if (emailLabel) {
            emailLabel.textContent = branch.quickActions.email.label;
        }

        if (emailValue) {
            emailValue.textContent = branch.quickActions.email.value;
        }

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
};

const initCatalogueLightbox = () => {
    const galleryItems = Array.from(document.querySelectorAll("[data-gallery-item]"));
    const lightbox = document.querySelector("[data-gallery-lightbox]");

    if (galleryItems.length === 0 || !lightbox) {
        return;
    }

    const lightboxImage = lightbox.querySelector("[data-gallery-image]");
    const lightboxCaption = lightbox.querySelector("[data-gallery-caption]");
    const lightboxCounter = lightbox.querySelector("[data-gallery-counter]");
    const closeButton = lightbox.querySelector("[data-gallery-close]");
    const prevButton = lightbox.querySelector("[data-gallery-prev]");
    const nextButton = lightbox.querySelector("[data-gallery-next]");
    const backdrop = lightbox.querySelector("[data-gallery-backdrop]");
    const pageBody = document.body;

    const items = galleryItems.map((item) => {
        const image = item.querySelector("img");

        return {
            source: item.getAttribute("href") || "",
            alt: image?.getAttribute("alt") || "",
            category: item.dataset.galleryTitle || "Gallery",
        };
    });

    let activeIndex = 0;

    const renderImage = () => {
        const activeItem = items[activeIndex];

        if (!activeItem || !lightboxImage || !lightboxCaption || !lightboxCounter) {
            return;
        }

        lightboxImage.src = activeItem.source;
        lightboxImage.alt = activeItem.alt;
        lightboxCaption.textContent = `${activeItem.category} - ${activeItem.alt}`;
        lightboxCounter.textContent = `${activeIndex + 1} / ${items.length}`;
    };

    const openLightbox = (index) => {
        activeIndex = index;
        renderImage();
        lightbox.hidden = false;
        pageBody.classList.add("lightbox-open");
    };

    const closeLightbox = () => {
        lightbox.hidden = true;
        pageBody.classList.remove("lightbox-open");

        if (lightboxImage) {
            lightboxImage.src = "";
        }
    };

    const showNext = () => {
        activeIndex = (activeIndex + 1) % items.length;
        renderImage();
    };

    const showPrevious = () => {
        activeIndex = (activeIndex - 1 + items.length) % items.length;
        renderImage();
    };

    galleryItems.forEach((item, index) => {
        item.addEventListener("click", (event) => {
            event.preventDefault();
            openLightbox(index);
        });
    });

    closeButton?.addEventListener("click", closeLightbox);
    nextButton?.addEventListener("click", showNext);
    prevButton?.addEventListener("click", showPrevious);

    lightbox.addEventListener("click", (event) => {
        if (event.target === lightbox || event.target === backdrop) {
            closeLightbox();
        }
    });

    document.addEventListener("keydown", (event) => {
        if (lightbox.hidden) {
            return;
        }

        if (event.key === "Escape") {
            closeLightbox();
        }

        if (event.key === "ArrowRight") {
            showNext();
        }

        if (event.key === "ArrowLeft") {
            showPrevious();
        }
    });
};

const initLogoCarousel = () => {
    const carousel = document.querySelector("[data-logo-carousel]");
    const track = carousel?.querySelector("[data-logo-track]");

    if (!carousel || !track) {
        return;
    }

    const baseItems = Array.from(track.children);

    if (baseItems.length === 0) {
        return;
    }

    const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    let currentIndex = 0;
    let intervalId = null;

    const getVisibleCount = () => {
        if (window.matchMedia("(max-width: 575.98px)").matches) {
            return 2;
        }

        if (window.matchMedia("(max-width: 767.98px)").matches) {
            return 2;
        }

        return 5;
    };

    const clearClones = () => {
        track.querySelectorAll("[data-logo-clone='true']").forEach((item) => item.remove());
    };

    const cloneItem = (item) => {
        const clone = item.cloneNode(true);
        clone.dataset.logoClone = "true";
        clone.setAttribute("aria-hidden", "true");
        return clone;
    };

    const getStepSize = () => {
        const firstItem = track.querySelector(".logo-carousel-item");

        if (!firstItem) {
            return 0;
        }

        const trackStyles = window.getComputedStyle(track);
        const gapValue = trackStyles.columnGap || trackStyles.gap || "0";
        const gap = Number.parseFloat(gapValue) || 0;

        return firstItem.getBoundingClientRect().width + gap;
    };

    const updateTransform = (animate) => {
        const stepSize = getStepSize();

        track.style.transition = animate ? "transform 0.65s ease" : "none";
        track.style.transform = stepSize > 0 ? `translateX(-${currentIndex * stepSize}px)` : "translateX(0)";
    };

    const stopAutoSlide = () => {
        if (intervalId !== null) {
            window.clearInterval(intervalId);
            intervalId = null;
        }
    };

    const startAutoSlide = () => {
        const visibleCount = getVisibleCount();

        if (prefersReducedMotion || intervalId !== null || baseItems.length <= visibleCount) {
            return;
        }

        intervalId = window.setInterval(() => {
            currentIndex += visibleCount;
            updateTransform(true);
        }, 2500);
    };

    const syncCarousel = () => {
        const visibleCount = getVisibleCount();
        const displayCount = Math.max(1, Math.min(baseItems.length, visibleCount));

        stopAutoSlide();
        clearClones();
        carousel.style.setProperty("--logo-visible-count", String(displayCount));
        currentIndex = 0;

        if (baseItems.length <= visibleCount) {
            carousel.classList.add("is-static");
            updateTransform(false);
            return;
        }

        carousel.classList.remove("is-static");

        baseItems.slice(0, visibleCount).forEach((item) => {
            track.appendChild(cloneItem(item));
        });

        updateTransform(false);
        startAutoSlide();
    };

    track.addEventListener("transitionend", () => {
        if (currentIndex < baseItems.length) {
            return;
        }

        currentIndex = 0;
        updateTransform(false);
    });

    carousel.addEventListener("mouseenter", stopAutoSlide);
    carousel.addEventListener("mouseleave", startAutoSlide);
    window.addEventListener("resize", syncCarousel);
    syncCarousel();
};

const initReviewsRotator = () => {
    const reviewDataNode = document.getElementById("reviews-data");
    const reviewSlots = Array.from(document.querySelectorAll("[data-review-slot]"));
    const reviewsRotator = document.querySelector("[data-reviews-rotator]");

    if (!reviewDataNode || reviewSlots.length === 0 || !reviewsRotator) {
        return;
    }

    let reviews = [];

    try {
        reviews = JSON.parse(reviewDataNode.textContent || "[]");
    } catch (error) {
        return;
    }

    if (reviews.length <= reviewSlots.length) {
        return;
    }

    let startIndex = 0;
    let intervalId = null;

    const buildStars = (rating) => {
        let markup = '<div class="review-stars" aria-label="' + rating + ' out of 5 stars">';

        for (let star = 0; star < 5; star += 1) {
            const className = star < rating ? "review-star is-filled" : "review-star";
            markup += '<span class="' + className + '">&#9733;</span>';
        }

        markup += "</div>";
        return markup;
    };

    const renderVisibleReviews = () => {
        reviewSlots.forEach((slot, slotIndex) => {
            const review = reviews[(startIndex + slotIndex) % reviews.length];
            const starsNode = slot.querySelector("[data-review-stars]");
            const copyNode = slot.querySelector("[data-review-copy]");
            const authorNode = slot.querySelector("[data-review-author]");
            const metaNode = slot.querySelector("[data-review-meta]");

            if (starsNode) {
                starsNode.innerHTML = buildStars(review.rating);
            }

            if (copyNode) {
                copyNode.textContent = review.copy;
            }

            if (authorNode) {
                authorNode.textContent = review.author;
            }

            if (metaNode) {
                metaNode.textContent = review.meta;
            }
        });
    };

    const advanceReviews = () => {
        reviewSlots.forEach((slot) => {
            slot.classList.add("is-swapping");
        });

        window.setTimeout(() => {
            startIndex = (startIndex + 1) % reviews.length;
            renderVisibleReviews();

            requestAnimationFrame(() => {
                reviewSlots.forEach((slot) => {
                    slot.classList.remove("is-swapping");
                });
            });
        }, 180);
    };

    const startAutoRotate = () => {
        if (intervalId !== null) {
            return;
        }

        if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
            return;
        }

        intervalId = window.setInterval(advanceReviews, 3200);
    };

    const stopAutoRotate = () => {
        if (intervalId !== null) {
            window.clearInterval(intervalId);
            intervalId = null;
        }
    };

    reviewsRotator.addEventListener("mouseenter", stopAutoRotate);
    reviewsRotator.addEventListener("mouseleave", startAutoRotate);
    reviewsRotator.addEventListener("focusin", stopAutoRotate);
    reviewsRotator.addEventListener("focusout", (event) => {
        if (event.relatedTarget && reviewsRotator.contains(event.relatedTarget)) {
            return;
        }

        startAutoRotate();
    });

    startAutoRotate();
};

document.addEventListener("DOMContentLoaded", () => {
    initContactTabs();
    initCatalogueLightbox();
    initLogoCarousel();
    initReviewsRotator();
});