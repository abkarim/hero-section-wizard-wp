import { __ } from "@wordpress/i18n";
import { InnerBlocks, useBlockProps } from "@wordpress/block-editor";
import { useSelect } from "@wordpress/data";
import "./editor.scss";

export default function Edit({ clientId }) {
    const TEMPLATE = [["hero-section-wizard/hero-section-slider-child", {}]];

    const innerBlocksCount = useSelect(
        (select) => {
            const block = select("core/block-editor").getBlock(clientId);
            return block ? block.innerBlocks.length : 0;
        },
        [clientId],
    );

    return (
        <section {...useBlockProps()}>
            <div className="slider-wrapper">
                <InnerBlocks
                    allowedBlocks={[
                        "hero-section-wizard/hero-section-slider-child",
                    ]}
                    template={TEMPLATE}
                    templateLock={false}
                />
            </div>
            {innerBlocksCount > 0 && (
                <div className="controls">
                    {Array.from({ length: innerBlocksCount }).map(
                        (_, index) => (
                            <span
                                key={index}
                                className={`control ${
                                    index === 0 ? "active" : ""
                                }`}
                            />
                        ),
                    )}
                </div>
            )}
        </section>
    );
}
