import { __ } from "@wordpress/i18n";
import {
    InnerBlocks,
    InspectorControls,
    useBlockProps,
} from "@wordpress/block-editor";
import { useSelect } from "@wordpress/data";
import { PanelBody, RangeControl } from "@wordpress/components";
import "./editor.scss";

export default function Edit({ clientId, attributes, setAttributes }) {
    const TEMPLATE = [["hero-section-wizard/hero-section-slider-child", {}]];

    const { borderRadius } = attributes;

    const blockProps = useBlockProps({
        style: {
            "--hero-section-slider-container-border-radius":
                borderRadius + "px",
        },
    });

    const innerBlocksCount = useSelect(
        (select) => {
            const block = select("core/block-editor").getBlock(clientId);
            return block ? block.innerBlocks.length : 0;
        },
        [clientId],
    );

    return (
        <>
            <InspectorControls>
                <PanelBody title="Slider Settings" initialOpen={true}>
                    <RangeControl
                        label="Border Radius (px)"
                        value={borderRadius || 0}
                        onChange={(value) =>
                            setAttributes({ borderRadius: value })
                        }
                        min={0}
                        max={100}
                        step={1}
                    />
                </PanelBody>
            </InspectorControls>
            <section {...blockProps}>
                <div className="slider-wrapper" data-active-slide-index="0">
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
        </>
    );
}
