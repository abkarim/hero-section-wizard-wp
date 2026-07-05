import { __ } from "@wordpress/i18n";
import { InnerBlocks, useBlockProps } from "@wordpress/block-editor";

import "./editor.scss";
export default function Edit() {
    const TEMPLATE = [
        [
            "core/heading",
            {
                level: 2,
                content: __("Slider Heading", "hero-section-wizard"),
            },
        ],
        [
            "core/paragraph",
            {
                content: __("Slider Paragraph", "hero-section-wizard"),
            },
        ],
        [
            "core/buttons",
            {},
            [
                [
                    "core/button",
                    {
                        text: "Get Started Now",
                    },
                ],
            ],
        ],
    ];
    return (
        <div {...useBlockProps()}>
            <InnerBlocks template={TEMPLATE} templateLock={false} />
        </div>
    );
}
