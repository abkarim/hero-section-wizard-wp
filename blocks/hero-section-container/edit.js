import {
    InnerBlocks,
    InspectorControls,
    useBlockProps,
} from "@wordpress/block-editor";
import { PanelBody, RangeControl } from "@wordpress/components";
import "./editor.scss";

export default function Edit({ attributes, setAttributes }) {
    const { gap } = attributes;

    const blockProps = useBlockProps({
        style: {
            "--hero-section-container-gap": gap + "em",
        },
    });

    const TEMPLATE = [
        [
            "hero-section-wizard/hero-section-slider-container",
            { className: "slider-container" },
        ],
        [
            "hero-section-wizard/hero-section-secondary-container",
            { className: "secondary-container" },
        ],
    ];

    return (
        <>
            <InspectorControls>
                <PanelBody title="Slider Settings" initialOpen={true}>
                    <RangeControl
                        label="Gap (em)"
                        value={gap || 1}
                        onChange={(value) => setAttributes({ gap: value })}
                        min={0}
                        max={100}
                        step={0.2}
                    />
                </PanelBody>
            </InspectorControls>
            <section {...blockProps}>
                <InnerBlocks template={TEMPLATE} templateLock="all" />
            </section>
        </>
    );
}
