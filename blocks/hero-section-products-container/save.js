import { useBlockProps } from "@wordpress/block-editor";

export default function save() {
    return (
        <section {...useBlockProps.save()}>
            {"Hero Section Products Container – hello from the saved content!"}
        </section>
    );
}
