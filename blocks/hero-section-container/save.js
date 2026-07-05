import { InnerBlocks, useBlockProps } from "@wordpress/block-editor";

export default function save({ attributes }) {
    const { gap } = attributes;

    const blockProps = useBlockProps.save({
        style: {
            "--hero-section-container-gap": gap + "em",
        },
    });

    return (
        <section {...blockProps}>
            <InnerBlocks.Content />
        </section>
    );
}
