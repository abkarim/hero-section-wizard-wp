import { InnerBlocks, useBlockProps } from "@wordpress/block-editor";

export default function save({ innerBlocks, attributes }) {
    const { borderRadius } = attributes;
    const slideCount = innerBlocks ? innerBlocks.length : 0;

    const blockProps = useBlockProps.save({
        style: {
            "--hero-section-slider-container-border-radius":
                borderRadius + "px",
        },
    });

    return (
        <section {...blockProps}>
            <div className="slider-wrapper" data-active-slide-index="0">
                <InnerBlocks.Content />
            </div>

            {slideCount > 0 && (
                <div className="controls">
                    {Array.from({ length: slideCount }).map((_, index) => (
                        <span
                            key={index}
                            className={`control ${index === 0 ? "active" : ""}`}
                        />
                    ))}
                </div>
            )}
        </section>
    );
}
