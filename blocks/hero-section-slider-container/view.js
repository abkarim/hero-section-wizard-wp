document.addEventListener("DOMContentLoaded", () => {
    const heroSectionSliderContainer = document.querySelector(
        ".wp-block-hero-section-wizard-hero-section-slider-container",
    );

    if (!heroSectionSliderContainer) return;

    const sliderWrapper =
        heroSectionSliderContainer.querySelector(".slider-wrapper");
    const controls = heroSectionSliderContainer.querySelector(".controls");

    const totalSlidesIndex = controls ? controls.childNodes.length - 1 : 0;
    let currentSlideIndex = 0;

    function canGoToNextSlide() {
        return currentSlideIndex < totalSlidesIndex;
    }

    function canGoToPreviousSlide() {
        return currentSlideIndex > 0;
    }

    function setDraggingSlideStateTransformValue(value) {
        if (value !== "") {
            heroSectionSliderContainer.style.setProperty(
                "--hero-section-slider-container-dragging-transform-value",
                `translateX(${value}%)`,
            );
        } else {
            heroSectionSliderContainer.style.removeProperty(
                "--hero-section-slider-container-dragging-transform-value",
            );
        }
    }

    function changeSlide(index, clickedControl) {
        currentSlideIndex = index;
        const activeControl = controls.querySelector(".control.active");
        if (activeControl) {
            activeControl.classList.remove("active");
        }

        controls.childNodes[index].classList.add("active");

        sliderWrapper.setAttribute("data-active-slide-index", index.toString());

        const transformValue = index < 1 ? 0 : index * 100;

        heroSectionSliderContainer.style.setProperty(
            "--hero-section-slider-container-transform-value",
            `translateX(-${transformValue}%)`,
        );
    }

    if (controls) {
        controls.addEventListener("click", (event) => {
            const clickedControl = event.target.closest(".control");
            const index = Array.from(controls.children).indexOf(clickedControl);

            if (index !== -1) changeSlide(index);
        });
    }

    let isDragging = false;
    let startX = 0;
    let startTime = 0;
    let slideToBe = null;

    sliderWrapper.addEventListener("pointerdown", (event) => {
        sliderWrapper.classList.add("dragging");
        isDragging = true;
        startX = event.clientX;
        startTime = event.timeStamp;
    });

    sliderWrapper.addEventListener("pointermove", (event) => {
        if (!isDragging) return;

        const currentX = event.clientX;
        const deltaX = currentX - startX;

        const currentTime = event.timeStamp;
        const deltaTime = currentTime - startTime;

        const velocityX = deltaX / (deltaTime || 1);

        const direction = deltaX < 0 ? "next" : "previous";

        const sensitivityThreshold = 0.5;
        const isFastSwipe = Math.abs(velocityX) > sensitivityThreshold;

        let value = 10;

        if (direction === "previous") {
            if (canGoToPreviousSlide()) {
                value = `-${parseInt(
                    currentSlideIndex * 100 -
                        (Math.abs(deltaX) / sliderWrapper.offsetWidth) * 100,
                )}`;
                if (Math.abs(value) < 50 || isFastSwipe) {
                    slideToBe = currentSlideIndex - 1;
                }
            }
        }

        if (direction === "next") {
            if (!canGoToNextSlide()) {
                value = `-${totalSlidesIndex * 100 + value}`;
            } else {
                value = `-${parseInt(
                    currentSlideIndex * 100 +
                        (Math.abs(deltaX) / sliderWrapper.offsetWidth) * 100,
                )}`;

                if (Math.abs(value) > 50 || isFastSwipe) {
                    slideToBe = currentSlideIndex + 1;
                } else {
                    slideToBe = null;
                }
            }
        }

        setDraggingSlideStateTransformValue(value);
    });

    function pointerCancel() {
        sliderWrapper.classList.remove("dragging");
        setDraggingSlideStateTransformValue("");
        isDragging = false;

        if (slideToBe !== null) {
            changeSlide(slideToBe);
        }
    }

    sliderWrapper.addEventListener("pointerup", pointerCancel);
    sliderWrapper.addEventListener("pointercancel", pointerCancel);
    sliderWrapper.addEventListener("pointerleave", pointerCancel);
});
