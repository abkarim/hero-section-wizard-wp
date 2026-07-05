document.addEventListener("DOMContentLoaded", () => {
    const heroSectionSliderContainer = document.querySelector(
        ".wp-block-hero-section-wizard-hero-section-slider-container",
    );

    if (heroSectionSliderContainer) {
        const sliderWrapper =
            heroSectionSliderContainer.querySelector(".slider-wrapper");

        const controls = heroSectionSliderContainer.querySelector(".controls");

        if (controls) {
            controls.addEventListener("click", (event) => {
                const clickedControl = event.target.closest(".control");
                const index = Array.from(controls.children).indexOf(
                    clickedControl,
                );

                if (index !== -1) {
                    const activeControl =
                        controls.querySelector(".control.active");
                    if (activeControl) {
                        activeControl.classList.remove("active");
                    }

                    clickedControl.classList.add("active");

                    sliderWrapper.setAttribute(
                        "data-active-slide-index",
                        index.toString(),
                    );

                    const transformValue = index < 1 ? 0 : index * 100;

                    heroSectionSliderContainer.style.setProperty(
                        "--hero-section-slider-container-transform-value",
                        `translateX(-${transformValue}%)`,
                    );
                }
            });
        }
    }
});
