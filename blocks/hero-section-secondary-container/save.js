import { InnerBlocks, useBlockProps } from "@wordpress/block-editor";

export default function save({ attributes }) {
    const { borderRadius, gap } = attributes;

    const blockProps = useBlockProps.save({
        style: {
            "--hero-section-secondary-container-border-radius":
                borderRadius + "px",
            "--hero-section-secondary-container-gap": gap + "em",
        },
    });

    return (
        <section {...blockProps}>
            <InnerBlocks.Content />
        </section>
    );
}
