import { __ } from "@wordpress/i18n";

import { useBlockProps } from "@wordpress/block-editor";

import "./editor.scss";

export default function Edit() {
    return (
        <section {...useBlockProps()}>
            {__(
                "Hero Section Products Container – hello from the editor!",
                "hero-section-wizard",
            )}
        </section>
    );
}
