import { InnerBlocks, useBlockProps } from "@wordpress/block-editor";

export default function save({ innerBlocks }) {
    const slideCount = innerBlocks ? innerBlocks.length : 0;

    return (
        <section {...useBlockProps.save()}>
            <div className="slider-wrapper">
                <InnerBlocks.Content />
            </div>

            {slideCount > 0 && (
                <div className="controls">
                    {Array.from({ length: slideCount }).map((_, index) => (
                        <span
                            key={index}
                            // Add active to the first slide dot as your starting layout
                            className={`control ${index === 0 ? "active" : ""}`}
                        />
                    ))}
                </div>
            )}
        </section>
    );
}
