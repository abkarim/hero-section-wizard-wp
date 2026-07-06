import { __ } from "@wordpress/i18n";
import { InnerBlocks, useBlockProps } from "@wordpress/block-editor";
import "./editor.scss";

export default function Edit() {
    const TEMPLATE = [
        [
            "core/heading",
            {
                level: 2,
                content: __("Awesome title", "hero-section-wizard"),
            },
        ],
        [
            "core/paragraph",
            {
                content: __("Awesome description", "hero-section-wizard"),
            },
        ],
        [
            "core/buttons",
            {},
            [
                [
                    "core/button",
                    {
                        text: "View Details",
                    },
                ],
            ],
        ],
    ];

    return (
        <section {...useBlockProps()}>
            <InnerBlocks template={TEMPLATE} templateLock={false} />
        </section>
    );
}
